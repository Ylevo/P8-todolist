# TodoList - Authentification

Ce document explique le fonctionnement du système d'authentification de Symfony utilisée dans cette application. Plusieurs méthodes d'authentification sont disponibles à travers le bundle `symfony/security-bundle`. C'est celle à base de formulaire classique qui est utilisée ici.

## Processus 

L'authentification s'opère typiquement ainsi :

1. L'utilisateur tente d'accéder à une page requérant d'être authentifié ou clique sur un lien menant vers la page de connexion.
2. Le [pare-feu](#firewall) démarre le processus d'authentification en (re)dirigeant l'utilisateur vers le formulaire de connexion.
3. La page de connexion (`/login`) rend le formulaire de connexion.
4. L'utilisateur rentre ses identifiants et soumet le formulaire.
5. Le système de sécurité (`FormLoginAuthenticator`) intercepte la requête, vérifie les identifiants soumis, authentifie l'utilisateur s'ils sont corrects et renvoie l'utilisateur au formulaire de connexion s'ils ne le sont pas.

Trois éléments importants interviennent dans ce processus : la classe [`User`](#classe-user), le contrôleur [`SecurityController`](#contrôleur-securitycontroller) et le fichier de configuration [`security.yaml`](#fichier-de-configuration-securityyaml).

## Classe User

La classe `User` implémente l'interface `UserInterface`, permettant d'indiquer à Symfony que la classe est utilisée pour l'authentification des utilisateurs. Elle implémente également l'interface `PasswordAuthenticatedUserInterface` pour configurer la méthode de hashing pour l'encryptage du mot de passe.
À noter que le nom de la classe en lui-même n'a pas d'importance tant qu'elle est correctement référencée dans les fichiers de configuration, bien qu'User soit utilisé par convention.

Dans cette application, les utilisateurs sont stockés en base de donnée. La classe contient les champs suivants :
* id
* username
* email
* password
* roles

Le champ `roles` permet d'ajouter ou - plus rarement - de retirer des permissions à chaque utilisateur. Le nom des rôles est libre mais doit toujours comporter le préfixe `ROLE_`. Dans cette application, les rôles `ROLE_USER` et `ROLE_ADMIN` sont utilisés. Plus d'informations sur l'usage des rôles dans la partie [Contrôle d'accès](#contrôle-daccès).

## Contrôleur SecurityController

Le contrôleur `SecurityController` gère traditionnellement trois routes : `/login`, `/login_check` et `/logout`. Seule la méthode de la route `/login` contient du code (pour le rendu du formulaire et sa soumission), le travail d'authentification en lui-même étant effectué par la classe `FormLoginAuthenticator` du security bundle. Ces routes sont indiquées dans le fichier de configuration essentiel, [`security.yaml`](#fichier-de-configuration-securityyaml).

## Fichier de configuration security.yaml

Situé dans **config/packages**, `security.yaml` contient toutes les options de configuration gérant l'authentification de l'application. Voici les parties les plus importantes.

### User Provider

Un `user provider` est essentiel à l'authentification. Il permet d'indiquer à symfony quelle classe est utilisée pour l'authentification et quelle propriété agit comme identifiant utilisateur. Le `user provider` permet également de "rafraichîr" l'utilisateur connecté en vérifiant que ses informations sont bien à jour à chaque nouvelle requête, et dans le cas contraire, le déconnecte si nécessaire. [Plus d'informations sur le user provider.](https://symfony.com/doc/current/security.html#user_session_refresh)

```yaml
# config/packages/security.yaml
security:
    # ...
    providers:
        # used to reload user from session & other features (e.g. switch_user)
        app_user_provider:
            entity:
                class: App\Entity\User
                property: username
```

Dans notre application `username` est utilisé, mais il aurait pu s'agir de l'email par exemple.

### Firewall

Les `firewalls` ou pare-feux configurent le système d'authentification. C'est le pare-feu `main` qui nous intéresse réellement ici, le `dev` n'étant là que pour éviter de bloquer par erreur les outils de développement de Symfony. 
On y retrouve notre `user provider` ainsi que nos trois routes `/login`, `/login_check` et `/logout` du SecurityController, ici référencées par leur nom d'annotation. `form_login` indique que nous utilisons une authentification à base de formulaire. `check_path` spécifie quelle route est utilisée pour la soumission du formulaire de connexion, `login_path` celle vers laquelle l'utilisateur est redirigée pour se connecter et `path` sous `logout` celle déclenchant la déconnexion. [Plus d'informations sur la configuration de form_login.](https://symfony.com/doc/current/reference/configuration/security.html#form-login-authentication)

```yaml
    firewalls:
        dev:
            pattern: ^/(_(profiler|wdt)|css|images|js)/
            security: false
        main:
            lazy: true
            provider: app_user_provider
            form_login:
                check_path: login_check
                login_path: login
                always_use_default_target_path: true
                default_target_path: /
                enable_csrf: true
            entry_point: 'form_login'
            logout:
                path: logout
```

### Contrôle d'accès

Plusieurs moyens existent dans Symfony pour restreindre l'accès à certaines pages. L'un d'entre eux est l'option `access_control` du fichier `security.yaml`. Celle-ci permet notamment de restreindre des parties entières de l'application en utilisant des expressions régulières pour les URL. Ainsi ici, toute route commençant par `/users` est restreinte aux utilisateurs ayant le rôle `ROLE_ADMIN`. Toutes les autres routes, hormis celle du formulaire de connexion, demandent d'avoir au moins le rôle `ROLE_USER`. [Plus d'informations sur l'option `access_control`](https://symfony.com/doc/current/security/access_control.html)

L'option `role_hierarchy` implémente un héritage des rôles, évitant d'avoir à attribuer manuellement plusieurs rôles à la fois. Dans notre application, `ROLE_USER` est automatiquement donné à un utilisateur ayant le rôle parent `ROLE_ADMIN`.

```yaml
    access_control:
        - { path: ^/login, roles: PUBLIC_ACCESS }
        - { path: ^/users, roles: ROLE_ADMIN }
        - { path: ^/, roles: ROLE_USER }

    role_hierarchy:
        ROLE_ADMIN: ROLE_USER
```

Un autre moyen de gérer l'accès utilisateur aurait été la méthode `denyAccessUnlessGranted` de la classe `AbstractController` :

```php
$this->denyAccessUnlessGranted('ROLE_ADMIN');
```

Ou encore l'attribut `#[IsGranted()]`.

Quel que soit la méthode utilisée, lorsqu'un accès est rejeté, une exception `AccessDeniedException` est jetée. Ensuite, soit l'utilisateur n'est pas connecté et il est redirigé vers le formulaire de connexion, soit il l'est et une page "403 access denied" s'affiche.
