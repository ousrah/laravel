<!-- =================================================================== -->
<!-- PARTIE 1 : DÉMARRAGE & FONDAMENTAUX -->
<!-- =================================================================== -->
<h2 class="text-3xl font-bold text-gray-800 border-b-2 border-gray-200 pb-2 mb-6">Partie 1 : Démarrage & Fondamentaux</h2>

<!-- ========== CHAPITRE 1 : INTRODUCTION AUX FRAMEWORKS & ÉCOSYSTÈME LARAVEL ========== -->
<section id="intro-laravel" class="mb-16">
    <h3 class="text-2xl font-semibold mb-3">Chapitre 1 : Introduction aux Frameworks & Écosystème Laravel</h3>
    <p class="text-xl text-gray-600 mb-8 leading-relaxed">Avant de plonger dans la première ligne de code Laravel, il est essentiel de comprendre pourquoi cet outil existe et en quoi il va radicalement changer votre façon de développer des applications PHP. Ce chapitre pose le contexte : nous définirons ce qu'est un framework, explorerons les alternatives et justifierons pourquoi Laravel est un choix de premier ordre pour les projets modernes.</p>
    
    <div class="bg-white p-6 rounded-lg shadow-sm border space-y-8 mt-8">
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">1.1. Qu'est-ce qu'un Framework PHP ?</h4>
            <p class="text-gray-700 mb-4"><strong>Analogie :</strong> Construire une application web sans framework, c'est comme construire une maison en fabriquant vous-même chaque brique, chaque tuile et chaque vis. C'est possible, mais c'est lent, répétitif et sujet aux erreurs. Un framework vous fournit un **plan d'architecte (une structure)** et une **caisse à outils de composants préfabriqués et testés (des bibliothèques)**.</p>
            <p class="text-gray-700 mb-4">Concrètement, un framework PHP vous évite de "réinventer la roue" en fournissant des solutions standardisées pour des problèmes récurrents :</p>
            <ul class="list-disc ml-6 text-gray-600 space-y-2 mb-4">
                <li>Le **routage** : Associer une URL (ex: `/contact`) à un fichier PHP spécifique.</li>
                <li>L'**accès à la base de données** : Fournir une couche d'abstraction (ORM) pour ne plus écrire de SQL à la main.</li>
                <li>La **sécurité** : Protéger contre les failles communes (XSS, CSRF, injections SQL).</li>
                <li>La **gestion des templates** : Séparer la logique PHP du code HTML.</li>
                <li>La **gestion des sessions** et de l'**authentification**.</li>
            </ul>
            <p class="text-gray-700 font-semibold mb-2 mt-4">Le problème que cela résout : le chaos du PHP "vanilla"</p>
            <div class="code-block-wrapper">
                <pre class="code-block"><code class="language-php"><span class="token-comment">// Un exemple de code "vanilla" pour une simple page produit</span>
<span class="token-preprocessor"><?php</span>
<span class="token-comment">// 1. Connexion manuelle à la BDD (vulnérable si mal gérée)</span>
<span class="token-variable">$pdo</span> = <span class="token-keyword">new</span> <span class="token-class-name">PDO</span>(<span class="token-string">'mysql:host=localhost;dbname=test'</span>, <span class="token-variable">$_ENV</span>[<span class="token-string">'DB_USER'</span>], <span class="token-variable">$_ENV</span>[<span class="token-string">'DB_PASS'</span>]);

<span class="token-comment">// 2. Routage basique et non sécurisé</span>
<span class="token-variable">$productId</span> = <span class="token-variable">$_GET</span>[<span class="token-string">'id'</span>] ?? <span class="token-number">0</span>;

<span class="token-comment">// 3. Requête SQL manuelle (risque d'injection SQL)</span>
<span class="token-variable">$stmt</span> = <span class="token-variable">$pdo</span>-><span class="token-function">prepare</span>(<span class="token-string">'SELECT * FROM products WHERE id = ?'</span>);
<span class="token-variable">$stmt</span>-><span class="token-function">execute</span>([<span class="token-variable">$productId</span>]);
<span class="token-variable">$product</span> = <span class="token-variable">$stmt</span>-><span class="token-function">fetch</span>();

<span class="token-comment">// 4. Logique et affichage mélangés</span>
<span class="token-keyword">if</span> (<span class="token-variable">$product</span>) {
    <span class="token-keyword">echo</span> <span class="token-string">"&lt;h1>"</span> . <span class="token-function">htmlspecialchars</span>(<span class="token-variable">$product</span>[<span class="token-string">'name'</span>]) . <span class="token-string">"&lt;/h1>"</span>;
} <span class="token-keyword">else</span> {
    <span class="token-function">http_response_code</span>(<span class="token-number">404</span>);
    <span class="token-keyword">echo</span> <span class="token-string">"&lt;h1>Produit non trouvé&lt;/h1>"</span>;
}
<span class="token-preprocessor">?></span>
</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
            <p class="text-gray-700 mt-4">Ce code est difficile à maintenir, à sécuriser et à faire évoluer. Un framework impose une structure propre qui résout ces problèmes dès le départ.</p>
        </div>

        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">1.2. Le Paysage des Frameworks PHP</h4>
            <p class="text-gray-700 mb-4">Le monde PHP est riche et plusieurs frameworks matures coexistent. Les deux acteurs majeurs sur le marché sont :</p>
            <ul class="list-disc ml-6 text-gray-600 space-y-2 mb-4">
                <li><strong>Symfony :</strong> Très robuste, modulaire et flexible. Il est souvent vu comme un ensemble de "briques logicielles" (composants) que l'on peut utiliser ensemble ou séparément. Sa courbe d'apprentissage est parfois jugée plus raide. De nombreux grands projets (Drupal, PrestaShop) sont basés sur ses composants.</li>
                <li><strong>Laravel :</strong> Il est réputé pour son élégance, sa simplicité et sa productivité. Sa philosophie est de fournir une solution "tout-en-un" très cohérente, qui rend le développement rapide et agréable. Il possède l'un des écosystèmes les plus riches (outils officiels pour le frontend, le déploiement, etc.).</li>
            </ul>
             <p class="text-gray-700 mb-4">D'autres frameworks comme Laminas (anciennement Zend Framework) ou CakePHP existent mais ont une part de marché plus faible aujourd'hui.</p>
        </div>
        
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">1.3. Pourquoi Choisir Laravel ? Avantages et Inconvénients</h4>
            <p class="text-gray-700 mb-4">Le choix d'un framework est souvent une question de philosophie et de besoins. Voici ce qui fait la force de Laravel, ainsi que quelques points de vigilance.</p>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Avantages -->
                <div class="bg-green-50 border border-green-200 p-4 rounded-lg">
                    <h5 class="font-bold text-lg text-green-800 mb-2">✅ Avantages</h5>
                    <ul class="list-disc ml-5 space-y-2 text-green-700">
                        <li><strong>Productivité & Élégance :</strong> Sa syntaxe est expressive et concise. Des outils comme l'ORM Eloquent ou le moteur de template Blade permettent de faire beaucoup avec peu de code.</li>
                        <li><strong>Écosystème "tout-en-un" :</strong> Laravel propose des outils officiels parfaitement intégrés pour l'authentification (Breeze), les API (Sanctum), le temps réel (Reverb), le déploiement (Forge), et bien plus.</li>
                        <li><strong>Communauté immense :</strong> Une documentation exemplaire, de très nombreux tutoriels, des packages pour tous les besoins et une aide facile à trouver.</li>
                        <li><strong>Artisan CLI :</strong> Sa ligne de commande est l'une des plus puissantes et des plus utiles pour générer du code et gérer l'application.</li>
                        <li><strong>Performances modernes :</strong> Avec les versions récentes de PHP, Laravel est devenu très performant et convient à la grande majorité des applications web.</li>
                    </ul>
                </div>
                
                <!-- Inconvénients -->
                <div class="bg-red-50 border border-red-200 p-4 rounded-lg">
                    <h5 class="font-bold text-lg text-red-800 mb-2">❌ Inconvénients</h5>
                     <ul class="list-disc ml-5 space-y-2 text-red-700">
                        <li><strong>La "Magie" :</strong> Laravel utilise beaucoup de "Facades" et de mécanismes en arrière-plan qui peuvent rendre la compréhension de son fonctionnement interne difficile pour un débutant. (Nous démystifierons cela !)</li>
                        <li><strong>Fortement "opinionné" :</strong> Laravel vous guide vers "sa" façon de faire les choses. C'est un avantage pour la productivité, mais cela peut être moins flexible que Symfony si vous avez besoin de sortir des sentiers battus.</li>
                        <li><strong>Mises à jour fréquentes :</strong> Le cycle de sortie rapide peut être un défi pour la maintenance de très gros projets sur le long terme, bien que des versions LTS (Long Term Support) existent.</li>
                    </ul>
                </div>
            </div>
            <p class="text-center text-gray-700 mt-6 font-semibold">Pour notre projet de gestion commerciale et pour la majorité des applications d'entreprise, les avantages de Laravel en termes de rapidité de développement et de clarté du code l'emportent largement. C'est un excellent choix pour apprendre et pour produire.</p>
        </div>
    </div>
    
    <div class="text-right mt-8"> <a href="#page-top" class="text-sm font-semibold text-blue-600 hover:underline">↑ Retour en haut</a> </div>
</section>
<!-- ========== CHAPITRE 2 : INSTALLATION & CONFIGURATION DE L'ENVIRONNEMENT ========== -->
<section id="install-env" class="mb-16">
    <h3 class="text-2xl font-semibold mb-3">Chapitre 2 : Installation & Configuration de l'Environnement</h3>
    <p class="text-xl text-gray-600 mb-8 leading-relaxed">Maintenant que nous avons posé les bases théoriques, nous allons passer à la pratique. Ce chapitre est un guide pour installer votre premier projet Laravel 12, configurer votre environnement de développement local et vous familiariser avec la structure des fichiers. L'objectif est simple : voir la page d'accueil de Laravel s'afficher dans votre navigateur.</p>
    
    <div class="bg-white p-6 rounded-lg shadow-sm border space-y-8 mt-8">
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">2.1. Prérequis Techniques</h4>
            <p class="text-gray-700 mb-4">Avant de commencer, assurez-vous que les outils suivants sont installés et accessibles depuis votre terminal. Laravel 12 a des exigences spécifiques :</p>
            <ul class="list-disc ml-6 text-gray-600 space-y-2 mb-4">
                <li><strong>PHP >= 8.2 :</strong> Laravel 12 requiert une version récente de PHP. Vérifiez votre version avec la commande `php -v`.</li>
                <li><strong>Composer :</strong> Le gestionnaire de dépendances pour PHP. Si vous ne l'avez pas, suivez les instructions sur <a href="https://getcomposer.org" target="_blank" class="text-blue-600 hover:underline">getcomposer.org</a>. Vérifiez votre version avec `composer -V`.</li>
                <li><strong>Node.js >= 18.0 & npm :</strong> Nécessaires pour l'écosystème frontend (Vite, Tailwind CSS). Téléchargez-les sur <a href="https://nodejs.org" target="_blank" class="text-blue-600 hover:underline">nodejs.org</a>. Vérifiez vos versions avec `node -v` et `npm -v`.</li>
                <li><strong>Un serveur de base de données :</strong> MySQL, MariaDB ou PostgreSQL. Assurez-vous d'avoir un outil pour gérer vos bases de données (phpMyAdmin, TablePlus, DBeaver, etc.).</li>
            </ul>
        </div>

        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">2.2. Création du Projet Laravel</h4>
            <p class="text-gray-700 mb-4">Il existe deux manières principales pour installer un nouveau projet Laravel.</p>
            <h5 class="font-semibold text-gray-800 mb-2 mt-6">Méthode 1 : Via le Laravel Installer (Recommandée)</h5>
            <p class="text-gray-700 mb-4">C'est la méthode la plus rapide. Elle nécessite d'installer globalement l'outil d'installation de Laravel une seule fois.</p>
            <div class="code-block-wrapper">
                <pre class="code-block"><code class="language-bash"><span class="token-comment"># Exécutez cette commande une seule fois sur votre machine pour installer le programme.</span>
composer global require laravel/installer

<span class="token-comment"># Ensuite, pour chaque nouveau projet, utilisez la commande `laravel new`. C'est très rapide.</span>
laravel new mon-projet-commercial
</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
            
            <h5 class="font-semibold text-gray-800 mb-2 mt-6">Méthode 2 : Via Composer Create-Project</h5>
            <p class="text-gray-700 mb-4">Cette méthode ne nécessite aucune installation globale. Composer télécharge le squelette de l'application et installe les dépendances dans la foulée.</p>
            <div class="code-block-wrapper">
                <pre class="code-block"><code class="language-bash"><span class="token-comment"># Cette commande crée directement le projet.</span>
composer create-project laravel/laravel mon-projet-commercial
</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
            <p class="text-gray-700 mt-4">Quelle que soit la méthode, naviguez ensuite dans le dossier du projet : `cd mon-projet-commercial`.</p>
        </div>

        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">2.3. Les Fichiers de Dépendances : `composer.json` et `package.json`</h4>
            <p class="text-gray-700 mb-4">Ces deux fichiers à la racine de votre projet sont la "liste des ingrédients" de votre application. Il est crucial de comprendre leur rôle.</p>
             <ul class="list-disc ml-6 text-gray-600 space-y-2 mb-4">
                <li>
                    <strong>`composer.json` :</strong> Gère les dépendances **côté serveur (PHP)**.
                    <p class="text-sm mt-1">C'est ici que sont listés le framework Laravel lui-même (`laravel/framework`), les packages pour gérer les bases de données, les API, etc. La section `require-dev` contient les outils utilisés uniquement en développement, comme les bibliothèques de test (PHPUnit).</p>
                </li>
                 <li>
                    <strong>`package.json` :</strong> Gère les dépendances **côté client (JavaScript/CSS)**.
                    <p class="text-sm mt-1">Ce fichier liste les outils de build comme Vite, et les bibliothèques frontend comme Tailwind CSS ou Alpine.js. La section `devDependencies` contient tout ce qui est nécessaire pour *construire* vos assets, mais qui ne se retrouvera pas dans le code final envoyé au navigateur.</p>
                </li>
            </ul>
        </div>
        
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">2.4. Exploration de la Structure des Dossiers</h4>
            <p class="text-gray-700 mb-4">Une fois le projet créé, ouvrez-le dans votre éditeur de code. Voici les dossiers les plus importants à connaître :</p>
            <ul class="list-disc ml-6 text-gray-600 space-y-2 mb-4">
                <li>`app/` : Le cœur de votre application (Modèles, Contrôleurs, Services).</li>
                <li>`routes/` : Les fichiers de routes (`web.php`, `api.php`).</li>
                <li>`resources/` : Les Vues (`views/`), les fichiers de langue (`lang/`) et les assets bruts.</li>
                <li>`public/` : Le seul dossier accessible depuis le web, point d'entrée de l'application.</li>
                <li>`database/` : Les migrations, seeders et factories.</li>
                <li>`.env` : Le fichier de configuration de votre environnement local.</li>
            </ul>
        </div>

        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">2.5. Configuration de l'Environnement (.env)</h4>
            <p class="text-gray-700 mb-4"><strong>Étape 1 : Créer la base de données</strong><br>
            Avec votre outil de gestion de BDD, créez une nouvelle base de données vide. Nommons-la `mon_projet_commercial` (en utilisant l'encodage `utf8mb4_unicode_ci`).</p>
            <p class="text-gray-700 mb-4"><strong>Étape 2 : Configurer le fichier `.env`</strong><br>
            Ouvrez le fichier `.env` et modifiez les variables de la base de données (`DB_...`) pour qu'elles correspondent à votre configuration locale.</p>
            <div class="code-block-wrapper">
                <pre class="code-block"><code class="language-ini"><span class="token-comment"># ...</span>
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mon_projet_commercial <span class="token-comment"># &lt;-- Le nom que vous venez de créer</span>
DB_USERNAME=root <span class="token-comment"># &lt;-- Votre utilisateur BDD</span>
DB_PASSWORD= <span class="token-comment"># &lt;-- Votre mot de passe BDD</span>
</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
        </div>

        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">2.6. Compilation des Assets : `dev` vs `build`</h4>
            <p class="text-gray-700 mb-4">Dans le fichier `package.json`, vous verrez des "scripts" comme `"dev"` et `"build"`. Ils servent à compiler vos fichiers CSS et JS, mais dans des contextes différents.</p>
            <ul class="list-disc ml-6 text-gray-600 space-y-3 mb-4">
                <li>
                    <strong>`npm run dev` : Pour le développement</strong>
                    <p class="text-sm mt-1">Cette commande lance un serveur de développement (Vite). Il surveille vos fichiers (`.css`, `.js`, `.blade.php`) et, dès que vous sauvegardez une modification, il recompile instantanément les assets et rafraîchit votre navigateur (Hot Module Replacement). C'est extrêmement rapide et pratique. <strong>Les fichiers générés ne sont pas optimisés.</strong></p>
                </li>
                 <li>
                    <strong>`npm run build` : Pour la production</strong>
                    <p class="text-sm mt-1">Cette commande fait un travail différent : elle lit tous vos assets, les optimise (minification, suppression du code inutilisé), les combine en de petits fichiers et les place dans le dossier `public/build`. C'est cette version optimisée que vous déploierez sur votre serveur de production.</p>
                </li>
            </ul>
        </div>

        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">2.7. Lancement des Serveurs de Développement</h4>
            <p class="text-gray-700 mb-4">Vous aurez besoin de **deux terminaux ouverts** à la racine de votre projet.</p>

            <p class="text-gray-700 mb-2"><strong>Étape 1 : Installer les dépendances frontend</strong></p>
            <div class="code-block-wrapper">
                <pre class="code-block"><code class="language-bash"><span class="token-comment"># Cette commande lit package.json et installe Vite, Tailwind, etc. dans le dossier `node_modules`.</span>
npm install
</code></pre>
                <button class="copy-btn">Copier</button>
            </div>

            <p class="text-gray-700 mt-4 mb-2"><strong>Étape 2 : Lancer les serveurs</strong></p>
            <div class="code-block-wrapper">
                <pre class="code-block"><code class="language-bash"><span class="token-comment"># Dans le Terminal 1 : Lancez le serveur Vite pour les assets.</span>
npm run dev

<span class="token-comment"># Dans le Terminal 2 : Lancez le serveur PHP avec Artisan.</span>
php artisan serve
</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
             <p class="text-gray-700 mt-4">Artisan vous donnera une URL, généralement `http://127.0.0.1:8000`. Ouvrez-la dans votre navigateur. Si tout est correct, vous devriez voir la page d'accueil de Laravel 12.</p>
        </div>
    </div>
    
    <!-- ========== ATELIER PRATIQUE DE LA PARTIE 1 ========== -->
    <section id="exercices-partie1" class="mb-16 mt-12">
        <h3 class="text-2xl font-semibold mb-3">Atelier Pratique : Validation de l'installation</h3>
        <p class="text-gray-700 mb-8">Cet exercice est une checklist pour s'assurer que votre environnement est parfaitement opérationnel pour la suite du cours.</p>
        <div class="bg-white p-6 rounded-lg shadow-sm border">
            <h4 class="text-xl font-bold text-gray-800 mb-2">Checklist de démarrage</h4>
            <ol class="list-decimal ml-6 text-gray-700 space-y-3">
                <li>
                    <strong>Valider les prérequis :</strong> Confirmez que les commandes `php -v`, `composer -V`, `node -v` et `npm -v` retournent des versions compatibles.
                </li>
                <li>
                    <strong>Installer le projet :</strong> Utilisez `laravel new mon-projet-commercial` ou `composer create-project...`.
                </li>
                 <li>
                    <strong>Préparer la base de données :</strong> Créez une base de données nommée `mon_projet_commercial`.
                </li>
                <li>
                    <strong>Configurer l'environnement :</strong> Remplissez les informations `DB_*` dans votre fichier `.env`.
                </li>
                <li>
                    <strong>Générer la clé d'application :</strong> Exécutez `php artisan key:generate` pour vous assurer que la variable `APP_KEY` dans le fichier `.env` est bien définie.
                </li>
                <li>
                    <strong>Installer les dépendances Node :</strong> Exécutez `npm install`.
                </li>
                <li>
                    <strong>Lancer les serveurs :</strong> Lancez `npm run dev` dans un terminal et `php artisan serve` dans un second.
                </li>
                <li>
                    <strong>Vérifier le résultat :</strong> Rendez-vous à l'adresse `http://127.0.0.1:8000`. Vous devez voir la page d'accueil de Laravel.
                </li>
            </ol>
            <div class="mt-6 p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg">
                <p><strong>🎉 Bravo !</strong> Si vous voyez la page d'accueil, votre environnement de développement est prêt. Vous êtes paré pour commencer à construire notre application.</p>
            </div>
        </div>
    </section>

    <div class="text-right mt-8"> <a href="#page-top" class="text-sm font-semibold text-blue-600 hover:underline">↑ Retour en haut</a> </div>
</section>

<!-- ========== CHAPITRE 3 : ARCHITECTURE & CYCLE DE VIE D'UNE REQUÊTE ========== -->
<section id="architecture-lifecycle" class="mb-16">
    <h3 class="text-2xl font-semibold mb-3">Chapitre 3 : Architecture & Cycle de Vie d'une Requête</h3>
    <p class="text-xl text-gray-600 mb-8 leading-relaxed">Votre projet Laravel est installé et fonctionnel. Mais que se passe-t-il exactement lorsque vous visitez `http://127.0.0.1:8000` ? Comment Laravel sait-il quelle page afficher ? Ce chapitre lève le voile sur la "magie" en décortiquant le cheminement d'une requête HTTP, du navigateur de l'utilisateur jusqu'à l'affichage de la page. Nous mettrons ensuite cette connaissance en pratique en créant nos premières pages personnalisées.</p>
    
    <div class="bg-white p-6 rounded-lg shadow-sm border space-y-8 mt-8">
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">3.1. Le Cycle de Vie d'une Requête : Le Grand Voyage</h4>
            <p class="text-gray-700 mb-4"><strong>Analogie :</strong> Imaginez que vous commandez un plat dans un restaurant. La requête HTTP est votre commande. Laravel est toute la cuisine organisée qui la traite.</p>
            <ol class="list-decimal ml-6 text-gray-600 space-y-3">
                <li><strong>Le Client (Vous) passe une Commande :</strong> Vous tapez `http://mon-site.com/produits` dans votre navigateur et appuyez sur Entrée.</li>
                <li><strong>Le Point d'Entrée (`public/index.php`) :</strong> Votre commande arrive au seul endroit public du restaurant : le comptoir. Toutes les requêtes, sans exception, passent par ce fichier.</li>
                <li><strong>Le "Noyau" (Kernel) prépare la Cuisine :</strong> Le fichier `index.php` charge le "Noyau" (Kernel) de Laravel. Ce dernier démarre tous les services essentiels de l'application (le Service Container, la gestion des erreurs, les logs...).</li>
                <li><strong>Le Maître d'Hôtel (Routeur) lit la Commande :</strong> Le Noyau passe la requête au Routeur. Le Routeur regarde votre commande (`/produits`) et consulte son carnet (`routes/web.php`) pour savoir quel cuisinier doit la préparer.</li>
                <li><strong>Le Cuisinier (Contrôleur) prépare le Plat :</strong> Le Routeur a trouvé une correspondance ! Il appelle la méthode `index()` du `ProductController`. C'est le Contrôleur qui orchestre la préparation.</li>
                <li><strong>Le Contrôleur utilise les Ingrédients (Modèles) :</strong> Le `ProductController` demande au `Product` (Modèle) de lui donner la liste de tous les produits de la base de données.</li>
                <li><strong>Le Plat est mis en forme (Vue) :</strong> Le Contrôleur, avec la liste des produits, la transmet à un "présentateur" (`produits.blade.php`). Cette Vue met en forme les données dans un plat final (le code HTML).</li>
                <li><strong>Le Serveur vous apporte le Plat (Réponse) :</strong> La Vue génère une réponse HTML complète, qui est renvoyée à votre navigateur pour être affichée.</li>
            </ol>
        </div>

        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">3.2. Le Routage : Le Gardien de votre Application (`routes/web.php`)</h4>
            <p class="text-gray-700 mb-4">Le fichier `routes/web.php` est le carnet de routes de votre application web. Il contient une liste d'URLs et dit à Laravel quoi faire pour chacune d'elles. C'est ici que nous allons définir la structure de notre site.</p>
            <p class="text-gray-700 mb-4">Commençons par modifier la route existante pour la faire pointer vers un contrôleur que nous allons créer.</p>
            <div class="code-block-wrapper">
                <pre class="code-block"><code class="language-php"><span class="token-comment">// Fichier : routes/web.php</span>

<span class="token-keyword">use</span> <span class="token-class-name">Illuminate\Support\Facades\Route</span>;
<span class="token-comment">// On importe le contrôleur que nous allons bientôt créer.</span>
<span class="token-keyword">use</span> <span class="token-class-name">App\Http\Controllers\HomeController</span>;

<span class="token-comment">/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/</span>

<span class="token-comment">// Au lieu de retourner une vue directement, on dit à Laravel :
// "Quand un utilisateur demande la racine '/', exécute la méthode 'index' de HomeController."
</span>Route::<span class="token-function">get</span>(<span class="token-string">'/'</span>, [HomeController::<span class="token-keyword">class</span>, <span class="token-string">'index'</span>]);
</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
        </div>

        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">3.3. Les Contrôleurs : Les Chefs d'Orchestre (`app/Http/Controllers`)</h4>
            <p class="text-gray-700 mb-4">Le contrôleur ne contient pas de HTML ou de SQL. Son seul rôle est de recevoir une requête, de coordonner les actions nécessaires (parler aux modèles, etc.) et de renvoyer une réponse. Utilisons Artisan pour créer notre `HomeController`.</p>
            <div class="code-block-wrapper">
                <pre class="code-block"><code class="language-bash"><span class="token-comment"># Cette commande crée un nouveau fichier : app/Http/Controllers/HomeController.php</span>
php artisan make:controller HomeController
</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
            <p class="text-gray-700 mt-4 mb-4">Modifions maintenant ce fichier pour y ajouter notre méthode `index`.</p>
            <div class="code-block-wrapper">
                <pre class="code-block"><code class="language-php"><span class="token-comment">// Fichier : app/Http/Controllers/HomeController.php</span>

<span class="token-preprocessor"><?php</span>

<span class="token-keyword">namespace</span> <span class="token-namespace">App\Http\Controllers</span>;

<span class="token-keyword">use</span> <span class="token-class-name">Illuminate\Http\Request</span>;
<span class="token-comment">// On importe la classe View pour être explicite.</span>
<span class="token-keyword">use</span> <span class="token-class-name">Illuminate\View\View</span>;

<span class="token-keyword">class</span> <span class="token-class-name">HomeController</span> <span class="token-keyword">extends</span> <span class="token-class-name">Controller</span>
{
    <span class="token-comment">/**
     * Affiche la page d'accueil.
     */</span>
    <span class="token-keyword">public</span> <span class="token-keyword">function</span> <span class="token-function">index</span>()
    {
        <span class="token-comment">// Le contrôleur demande à Laravel de retourner la vue qui se trouve dans</span>
        <span class="token-comment">// resources/views/welcome.blade.php</span>
        <span class="token-keyword">return</span> <span class="token-function">view</span>(<span class="token-string">'welcome'</span>);
    }
}
</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
            <p class="text-gray-700 mt-4">Si vous actualisez votre navigateur, la page d'accueil devrait toujours s'afficher. Rien n'a changé visuellement, mais nous avons mis en place une architecture MVC propre !</p>
        </div>

        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">3.4. Les Vues & Blade : L'Interface Utilisateur (`resources/views`)</h4>
            <p class="text-gray-700 mb-4">Les vues sont de simples fichiers HTML avec des super-pouvoirs. Le moteur de template de Laravel, **Blade**, nous permet d'y injecter de la logique PHP (variables, conditions, boucles) de manière simple et lisible.</p>
            <p class="text-gray-700 mb-4">Modifions notre `HomeController` pour passer des données à la vue.</p>
             <div class="code-block-wrapper">
                <pre class="code-block"><code class="language-php"><span class="token-comment">// Fichier : app/Http/Controllers/HomeController.php</span>
<span class="token-comment">// ...</span>
    <span class="token-keyword">public</span> <span class="token-keyword">function</span> <span class="token-function">index</span>()
    {
        <span class="token-variable">$nom</span> = <span class="token-string">'Oussama'</span>;
        <span class="token-variable">$titre</span> = <span class="token-string">'Bienvenue sur notre application de gestion'</span>;

        <span class="token-comment">// Le 2ème argument de la fonction view() est un tableau de données.</span>
        <span class="token-comment">// La clé ('pageTitle') sera le nom de la variable dans la vue.</span>
        <span class="token-keyword">return</span> <span class="token-function">view</span>(<span class="token-string">'welcome'</span>, [
            <span class="token-string">'pageTitle'</span> => <span class="token-variable">$titre</span>,
            <span class="token-string">'userName'</span> => <span class="token-variable">$nom</span>
        ]);
    }
<span class="token-comment">// ...</span>
</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
            <p class="text-gray-700 mt-4 mb-4">Maintenant, affichons ces données dans notre vue `welcome.blade.php`.</p>
             <div class="code-block-wrapper">
                <pre class="code-block"><code class="language-html"><span class="token-comment">&lt;!-- Fichier : resources/views/welcome.blade.php --></span>
&lt;!DOCTYPE html>
&lt;html lang="fr">
&lt;head>

    &lt;title>{{ $pageTitle }}&lt;/title>
&lt;/head>
&lt;body>
    &lt;h1>Bonjour, {{ $userName }} !&lt;/h1>
    &lt;p>{{ $pageTitle }}&lt;/p>
&lt;/body>
&lt;/html>
</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
        </div>
    </div>
    
    <!-- ========== ATELIER PRATIQUE  ========== -->
    <section id="exercices-partie1-chap3" class="mb-16 mt-12">
        <h3 class="text-2xl font-semibold mb-3">Atelier Pratique : Créer vos Premières Pages</h3>
        <p class="text-gray-700 mb-8">Nous allons maintenant appliquer ce que nous venons d'apprendre pour créer deux pages statiques pour notre application : une page "Contact" et une page "À Propos". Je vais vous fournir le code complet pour la page "Contact", et votre exercice sera de créer la page "À Propos" en suivant exactement le même modèle.</p>
        
        <div class="bg-white p-6 rounded-lg shadow-sm border space-y-6">
            <h4 class="text-xl font-bold text-gray-800 mb-2">Mise en place de la page "Contact"</h4>
            
            <p class="font-semibold text-gray-700">1. Créer le Contrôleur</p>
            <div class="code-block-wrapper">
                <pre class="code-block"><code class="language-bash">php artisan make:controller ContactController
</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
            <p class="font-semibold text-gray-700">2. Remplir le Contrôleur (`app/Http/Controllers/ContactController.php`)</p>
             <div class="code-block-wrapper">
                <pre class="code-block"><code class="language-php"><span class="token-preprocessor"><?php</span>
<span class="token-keyword">namespace</span> <span class="token-namespace">App\Http\Controllers</span>;
<span class="token-keyword">use</span> <span class="token-class-name">Illuminate\View\View</span>;

<span class="token-keyword">class</span> <span class="token-class-name">ContactController</span> <span class="token-keyword">extends</span> <span class="token-class-name">Controller</span>
{
    <span class="token-keyword">public</span> <span class="token-keyword">function</span> <span class="token-function">index</span>(): View
    {
        <span class="token-keyword">return</span> <span class="token-function">view</span>(<span class="token-string">'contact'</span>);
    }
}
</code></pre>
                <button class="copy-btn">Copier</button>
            </div>

            <p class="font-semibold text-gray-700">3. Créer la Vue (`resources/views/contact.blade.php`)</p>
            <div class="code-block-wrapper">
                <pre class="code-block"><code class="language-html">&lt;!DOCTYPE html>
&lt;html lang="fr">
&lt;head>
    &lt;title>Contactez-nous&lt;/title>
&lt;/head>
&lt;body>
    &lt;h1>Page de Contact&lt;/h1>
    &lt;p>Vous pouvez nous contacter à l'adresse contact@gestcom.ma&lt;/p>
&lt;/body>
&lt;/html>
</code></pre>
                <button class="copy-btn">Copier</button>
            </div>

            <p class="font-semibold text-gray-700">4. Ajouter la Route (`routes/web.php`)</p>
             <div class="code-block-wrapper">
                <pre class="code-block"><code class="language-php"><span class="token-comment">// ... au début du fichier, n'oubliez pas d'importer le contrôleur</span>
<span class="token-keyword">use</span> <span class="token-class-name">App\Http\Controllers\ContactController</span>;

<span class="token-comment">// ... ajoutez cette ligne à la fin du fichier</span>
Route::<span class="token-function">get</span>(<span class="token-string">'/contact'</span>, [ContactController::<span class="token-keyword">class</span>, <span class="token-string">'index'</span>]);
</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
             <p class="text-gray-700">Maintenant, visitez `http://127.0.0.1:8000/contact`. Votre page doit s'afficher !</p>
        </div>

        <div class="mt-8 p-6 bg-blue-50 border-l-4 border-blue-500">
            <h4 class="text-xl font-bold text-gray-800 mb-2">Exercice : Créer la page "À Propos"</h4>
            <p class="text-gray-700 mb-4">Votre mission est de créer une nouvelle page accessible à l'URL `/a-propos`. Suivez les 4 mêmes étapes que pour la page "Contact" :</p>
            <ol class="list-decimal ml-6 font-semibold text-gray-800 space-y-2">
                <li>Créez un `AProposController` avec la commande `artisan`.</li>
                <li>Ajoutez une méthode `index()` dans ce contrôleur qui retourne une vue nommée `a-propos`.</li>
                <li>Créez le fichier de vue `resources/views/a-propos.blade.php` avec un contenu simple.</li>
                <li>Ajoutez la route `Route::get('/a-propos', ...)` dans votre fichier `routes/web.php`.</li>
            </ol>
            
            <button class="solution-toggle">Voir la solution</button>
            <div class="solution-content space-y-6">
                <p class="font-semibold text-gray-700 mt-4">1. Créer le Contrôleur avec Artisan</p>
                <div class="code-block-wrapper">
                    <pre class="code-block"><code class="language-bash">php artisan make:controller AProposController</code></pre>
                    <button class="copy-btn">Copier</button>
                </div>

                <p class="font-semibold text-gray-700">2. Remplir le Contrôleur (`app/Http/Controllers/AProposController.php`)</p>
                 <div class="code-block-wrapper">
                    <pre class="code-block"><code class="language-php"><span class="token-preprocessor"><?php</span>
<span class="token-keyword">namespace</span> <span class="token-namespace">App\Http\Controllers</span>;
<span class="token-keyword">use</span> <span class="token-class-name">Illuminate\View\View</span>;

<span class="token-keyword">class</span> <span class="token-class-name">AProposController</span> <span class="token-keyword">extends</span> <span class="token-class-name">Controller</span>
{
    <span class="token-keyword">public</span> <span class="token-keyword">function</span> <span class="token-function">index</span>(): View
    {
        <span class="token-keyword">return</span> <span class="token-function">view</span>(<span class="token-string">'a-propos'</span>);
    }
}
</code></pre>
                    <button class="copy-btn">Copier</button>
                </div>

                <p class="font-semibold text-gray-700">3. Créer la Vue (`resources/views/a-propos.blade.php`)</p>
                <div class="code-block-wrapper">
                    <pre class="code-block"><code class="language-html">&lt;!DOCTYPE html>
&lt;html lang="fr">
&lt;head>
    &lt;title>À Propos de Nous&lt;/title>
&lt;/head>
&lt;body>
    &lt;h1>À Propos de notre Société&lt;/h1>
    &lt;p>Nous sommes une entreprise spécialisée dans la gestion commerciale.&lt;/p>
&lt;/body>
&lt;/html>
</code></pre>
                    <button class="copy-btn">Copier</button>
                </div>

                <p class="font-semibold text-gray-700">4. Ajouter la Route (`routes/web.php`)</p>
                 <div class="code-block-wrapper">
                    <pre class="code-block"><code class="language-php"><span class="token-comment">// ... au début du fichier, importez le nouveau contrôleur</span>
<span class="token-keyword">use</span> <span class="token-class-name">App\Http\Controllers\AProposController</span>;

<span class="token-comment">// ... ajoutez cette ligne à la suite des autres routes</span>
Route::<span class="token-function">get</span>(<span class="token-string">'/a-propos'</span>, [AProposController::<span class="token-keyword">class</span>, <span class="token-string">'index'</span>]);
</code></pre>
                    <button class="copy-btn">Copier</button>
                </div>
                 <p class="text-gray-700">Une fois ces 4 étapes réalisées, visitez `http://127.0.0.1:8000/a-propos` pour vérifier le résultat.</p>
            </div>
        </div>
    </section>

    <div class="text-right mt-8"> <a href="#page-top" class="text-sm font-semibold text-blue-600 hover:underline">↑ Retour en haut</a> </div>
</section>
