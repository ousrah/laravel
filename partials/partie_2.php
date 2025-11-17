<!-- =================================================================== -->
<!-- PARTIE 2 : MODÈLES, BASE DE DONNÉES & ELOQUENT -->
<!-- =================================================================== -->
<h2 class="text-3xl font-bold text-gray-800 border-b-2 border-gray-200 pb-2 mb-6">Partie 2 : Modèles, Base de Données & Eloquent</h2>

<!-- ========== CHAPITRE 4 : MIGRATIONS, FACTORIES & SEEDERS ========== -->
<section id="migrations-seeders" class="mb-16">
    <h3 class="text-2xl font-semibold mb-3">Chapitre 4 : Migrations, Factories & Seeders</h3>
    <p class="text-xl text-gray-600 mb-8 leading-relaxed">Nous allons construire les fondations de notre application : sa base de données. Au lieu de créer des tables manuellement, nous allons découvrir la méthode professionnelle utilisée par les équipes de développement : les migrations pour structurer la base de données, et les factories/seeders pour la peupler avec des données de test de haute qualité.</p>
    
    <div class="bg-white p-6 rounded-lg shadow-sm border space-y-8 mt-8">
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">4.1. Migrations : Le Versionnement de votre Base de Données</h4>
            <p class="text-gray-700 mb-4"><strong>Analogie :</strong> Pensez aux migrations comme à un "Git" pour votre base de données. Chaque migration est un fichier PHP qui décrit une modification du schéma. Cela permet de garder un historique des changements et de reconstruire la base de données de n'importe qui en une seule commande.</p>
            
            <h5 class="font-semibold text-gray-800 mb-2 mt-6">Création d'une table</h5>
            <div class="code-block-wrapper">
                <pre class="code-block"><code class="language-bash">php artisan make:migration create_products_table</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
            <p class="text-gray-700 mt-4 mb-4">Remplissons la méthode `up()` du fichier de migration généré dans `database/migrations/`.</p>
             <div class="code-block-wrapper">
                <pre class="code-block"><code class="language-php"><span class="token-keyword">public</span> <span class="token-keyword">function</span> <span class="token-function">up</span>(): <span class="token-keyword">void</span>
{
    Schema::<span class="token-function">create</span>(<span class="token-string">'products'</span>, <span class="token-keyword">function</span> (Blueprint <span class="token-variable">$table</span>) {
        <span class="token-variable">$table</span>-><span class="token-function">id</span>();
        <span class="token-variable">$table</span>-><span class="token-function">string</span>(<span class="token-string">'name'</span>);
        <span class="token-variable">$table</span>-><span class="token-function">text</span>(<span class="token-string">'description'</span>)-><span class="token-function">nullable</span>();
        <span class="token-variable">$table</span>-><span class="token-function">decimal</span>(<span class="token-string">'price'</span>, <span class="token-number">8</span>, <span class="token-number">2</span>);
        <span class="token-variable">$table</span>-><span class="token-function">integer</span>(<span class="token-string">'stock'</span>)-><span class="token-function">default</span>(<span class="token-number">0</span>);
        <span class="token-variable">$table</span>-><span class="token-function">timestamps</span>();
    });
}
</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
        </div>

        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">4.2. Exécution et Annulation des Migrations</h4>
             <div class="code-block-wrapper">
                <pre class="code-block"><code class="language-bash"><span class="token-comment"># Exécute les nouvelles migrations</span>
php artisan migrate

<span class="token-comment"># Annule la dernière migration</span>
php artisan migrate:rollback

<span class="token-comment"># Annule les 3 dernières migrations</span>
php artisan migrate:rollback --step=3

<span class="token-comment"># Supprime toutes les tables et relance toutes les migrations</span>
php artisan migrate:fresh
</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
        </div>
        
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">4.3. Modification de Tables Existantes</h4>
            <p class="text-gray-700 mb-4">Pour modifier une table, on crée une **nouvelle** migration. Installez d'abord le package `doctrine/dbal` avec `composer require doctrine/dbal` pour permettre la modification de colonnes.</p>
            <div class="code-block-wrapper">
                <pre class="code-block"><code class="language-bash">php artisan make:migration modify_products_table</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
            <p class="text-gray-700 mt-4 mb-4">Modifions le nouveau fichier de migration :</p>
            <div class="code-block-wrapper">
                <pre class="code-block"><code class="language-php"><span class="token-keyword">public</span> <span class="token-keyword">function</span> <span class="token-function">up</span>(): <span class="token-keyword">void</span>
{
    Schema::<span class="token-function">table</span>(<span class="token-string">'products'</span>, <span class="token-keyword">function</span> (Blueprint <span class="token-variable">$table</span>) {
        <span class="token-variable">$table</span>-><span class="token-function">boolean</span>(<span class="token-string">'is_active'</span>)-><span class="token-function">default</span>(<span class="token-keyword">true</span>)-><span class="token-function">after</span>(<span class="token-string">'stock'</span>); // Ajouter une colonne
        <span class="token-variable">$table</span>-><span class="token-function">decimal</span>(<span class="token-string">'price'</span>, <span class="token-number">10</span>, <span class="token-number">2</span>)-><span class="token-function">change</span>(); // Modifier une colonne
    });
}
<span class="token-keyword">public</span> <span class="token-keyword">function</span> <span class="token-function">down</span>(): <span class="token-keyword">void</span>
{
    Schema::<span class="token-function">table</span>(<span class="token-string">'products'</span>, <span class="token-keyword">function</span> (Blueprint <span class="token-variable">$table</span>) {
        <span class="token-variable">$table</span>-><span class="token-function">decimal</span>(<span class="token-string">'price'</span>, <span class="token-number">8</span>, <span class="token-number">2</span>)-><span class="token-function">change</span>();
        <span class="token-variable">$table</span>-><span class="token-function">dropColumn</span>(<span class="token-string">'is_active'</span>); // Supprimer une colonne
    });
}
</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
        </div>
        
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">4.4. Seeders : La Méthode Manuelle</h4>
            <p class="text-gray-700 mb-4">Les Seeders sont des classes dont le seul but est de peupler la base de données. Commençons par la méthode la plus simple : l'insertion manuelle.</p>
            <p class="font-semibold text-gray-700">1. Créer le Seeder</p>
            <div class="code-block-wrapper">
                <pre class="code-block"><code class="language-bash">php artisan make:seeder ProductSeeder</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
            <p class="font-semibold text-gray-700 mt-4">2. Remplir le Seeder avec des données</p>
            <div class="code-block-wrapper">
                <pre class="code-block"><code class="language-php"><span class="token-comment">// Fichier : database/seeders/ProductSeeder.php</span>
<span class="token-keyword">use</span> <span class="token-class-name">Illuminate\Support\Facades\DB</span>;
<span class="token-keyword">public</span> <span class="token-keyword">function</span> <span class="token-function">run</span>(): <span class="token-keyword">void</span>
{
    DB::<span class="token-function">table</span>(<span class="token-string">'products'</span>)-><span class="token-function">insert</span>([
        [ 'name' => 'Laptop Pro', 'price' => 1299.99, /* ... */ ],
        [ 'name' => 'Souris Ergonomique', 'price' => 79.50, /* ... */ ]
    ]);
}
</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
            <p class="text-gray-700 mt-4">Cette méthode fonctionne, mais elle est fastidieuse et les données sont toujours les mêmes.</p>
            <p class="font-semibold text-gray-700 mt-4">3. Enregistrer et Exécuter le Seeder</p>
            <p class="text-gray-700 mb-4">Pour que Laravel exécute ce seeder, il faut l'appeler depuis le fichier principal `DatabaseSeeder.php`.</p>
            <div class="code-block-wrapper">
                <pre class="code-block"><code class="language-php"><span class="token-comment">// Fichier : database/seeders/DatabaseSeeder.php</span>
<span class="token-keyword">public</span> <span class="token-keyword">function</span> <span class="token-function">run</span>(): <span class="token-keyword">void</span>
{
    $this-><span class="token-function">call</span>([
        ProductSeeder::<span class="token-keyword">class</span>,
    ]);
}
</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
            <p class="text-gray-700 mt-4">Vous pouvez maintenant lancer le "seeding" avec : `php artisan db:seed`.</p>
        </div>

        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">4.5. Factories : La Méthode Professionnelle</h4>
            <p class="text-gray-700 mb-4">Une approche bien plus puissante consiste à utiliser des **Factories**. Ce sont des "usines à données" qui définissent une "recette" pour créer un modèle avec des données factices mais réalistes (noms, paragraphes, prix aléatoires...) grâce à la bibliothèque Faker.</p>
            
            <p class="font-semibold text-gray-700">1. Créer le Modèle et sa Factory</p>
            <div class="code-block-wrapper">
                <pre class="code-block"><code class="language-bash"><span class="token-comment"># Crée le modèle `app/Models/Product.php` ET sa factory `database/factories/ProductFactory.php`</span>
php artisan make:model Product -f
</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
            <p class="font-semibold text-gray-700 mt-4">2. Configurer la Factory</p>
            <div class="code-block-wrapper">
                <pre class="code-block"><code class="language-php"><span class="token-comment">// Fichier : database/factories/ProductFactory.php</span>
<span class="token-keyword">class</span> <span class="token-class-name">ProductFactory</span> <span class="token-keyword">extends</span> <span class="token-class-name">Factory</span>
{
    <span class="token-keyword">public</span> <span class="token-keyword">function</span> <span class="token-function">definition</span>(): array
    {
        <span class="token-keyword">return</span> [
            <span class="token-string">'name'</span> => <span class="token-variable">$this</span>->faker-><span class="token-function">words</span>(<span class="token-number">3</span>, <span class="token-keyword">true</span>),
            <span class="token-string">'description'</span> => <span class="token-variable">$this</span>->faker-><span class="token-function">paragraph</span>(),
            <span class="token-string">'price'</span> => <span class="token-variable">$this</span>->faker-><span class="token-function">randomFloat</span>(<span class="token-number">2</span>, <span class="token-number">10</span>, <span class="token-number">1000</span>),
            <span class="token-string">'stock'</span> => <span class="token-variable">$this</span>->faker-><span class="token-function">numberBetween</span>(<span class="token-number">0</span>, <span class="token-number">200</span>),
            <span class="token-string">'is_active'</span> => <span class="token-variable">$this</span>->faker-><span class="token-function">boolean</span>(<span class="token-number">90</span>)
        ];
    }
}
</code></pre>
                <button class="copy-btn">Copier</button>
            </div>

            <p class="font-semibold text-gray-700 mt-4">3. Utiliser la Factory dans le Seeder</p>
            <p class="text-gray-700 mb-4">Il suffit maintenant de refactoriser notre `ProductSeeder` pour qu'il utilise cette factory. C'est beaucoup plus simple !</p>
            <div class="code-block-wrapper">
                <pre class="code-block"><code class="language-php"><span class="token-comment">// Fichier : database/seeders/ProductSeeder.php</span>
<span class="token-keyword">use</span> <span class="token-class-name">App\Models\Product</span>; <span class="token-comment">// N'oubliez pas d'importer le modèle</span>

<span class="token-keyword">public</span> <span class="token-keyword">function</span> <span class="token-function">run</span>(): <span class="token-keyword">void</span>
{
    <span class="token-comment">// Crée 50 produits avec des données réalistes et aléatoires.</span>
    Product::<span class="token-function">factory</span>()-><span class="token-function">count</span>(<span class="token-number">50</span>)-><span class="token-function">create</span>();
}
</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
            <p class="text-gray-700 mt-4">La commande `php artisan migrate:fresh --seed` devient maintenant votre meilleure alliée pour réinitialiser et repeupler toute la base de données en un instant.</p>
        </div>
    </div>
    
    <!-- ========== ATELIER PRATIQUE  ========== -->
    <section id="exercices-partie2-chap4" class="mb-16 mt-12">
        <h3 class="text-2xl font-semibold mb-3">Atelier Pratique : Lier les Produits et les Catégories</h4>
        <p class="text-gray-700 mb-8">Votre mission est de finaliser la structure de base en créant la table `categories` et en liant chaque produit à une catégorie, en utilisant la méthode professionnelle avec les factories.</p>
        
        <div class="mt-8 p-6 bg-blue-50 border-l-4 border-blue-500">
            <h4 class="text-xl font-bold text-gray-800 mb-2">Exercice : Mettre en place la relation `products` <> `categories`</h4>
            <ol class="list-decimal ml-6 font-semibold text-gray-800 space-y-2">
                <li>Créez un modèle `Category` avec sa migration, sa factory et son seeder en une seule commande.</li>
                <li>Remplissez la migration `create_categories_table` avec une colonne `name`.</li>
                <li>Configurez la `CategoryFactory` pour générer un nom de catégorie (ex: `fake()->unique()->jobTitle()`).</li>
                <li>Configurez le `CategorySeeder` pour créer 10 catégories en utilisant sa factory.</li>
                <li>Créez une **nouvelle migration** pour ajouter une colonne `category_id` à la table `products` et en faire une clé étrangère.</li>
                <li>Mettez à jour la `ProductFactory` pour qu'elle assigne un ID de catégorie aléatoire à chaque produit créé.</li>
                <li>Mettez à jour le `DatabaseSeeder` pour appeler le `CategorySeeder` **avant** le `ProductSeeder`.</li>
                <li>Lancez `php artisan migrate:fresh --seed` et vérifiez le résultat.</li>
            </ol>
            
            <button class="solution-toggle">Voir la solution</button>
            <div class="solution-content space-y-6">
                <p class="font-semibold text-gray-700 mt-4">1. Créer les fichiers pour `Category`</p>
                <div class="code-block-wrapper"><pre class="code-block"><code class="language-bash">php artisan make:model Category -mfs</code></pre><button class="copy-btn">Copier</button></div>

                <p class="font-semibold text-gray-700">2 & 3. Remplir migration et factory de `Category`</p>
                <p class="text-sm text-gray-600">Fichier `..._create_categories_table.php` : ajoutez `$table->string('name');`.</p>
                <p class="text-sm text-gray-600">Fichier `CategoryFactory.php` : dans `definition()`, retournez `['name' => $this->faker->unique()->jobTitle()]`.</p>

                <p class="font-semibold text-gray-700">4. Remplir `CategorySeeder.php`</p>
                 <div class="code-block-wrapper"><pre class="code-block"><code class="language-php">use App\Models\Category;
public function run(): void { Category::factory(10)->create(); }</code></pre><button class="copy-btn">Copier</button></div>

                <p class="font-semibold text-gray-700">5. Créer la migration pour la clé étrangère</p>
                <div class="code-block-wrapper"><pre class="code-block"><code class="language-bash">php artisan make:migration add_category_id_to_products_table</code></pre><button class="copy-btn">Copier</button></div>
                <p class="font-semibold text-gray-700">Contenu de la migration (`up()`):</p>
                <div class="code-block-wrapper"><pre class="code-block"><code class="language-php">Schema::table('products', function (Blueprint $table) {
    $table->foreignId('category_id')->nullable()->after('id')->constrained()->onDelete('set null');
});
</code></pre><button class="copy-btn">Copier</button></div>

                <p class="font-semibold text-gray-700">6. Mettre à jour `ProductFactory.php`</p>
                 <div class="code-block-wrapper"><pre class="code-block"><code class="language-php">use App\Models\Category;
// ... dans la méthode definition()
'category_id' => Category::inRandomOrder()->first()->id,
</code></pre><button class="copy-btn">Copier</button></div>
                
                 <p class="font-semibold text-gray-700">7. Mettre à jour `DatabaseSeeder.php`</p>
                 <div class="code-block-wrapper"><pre class="code-block"><code class="language-php">public function run(): void
{
    $this->call([
        CategorySeeder::class, // Les catégories doivent exister avant les produits !
        ProductSeeder::class,
    ]);
}
</code></pre><button class="copy-btn">Copier</button></div>

                <p class="font-semibold text-gray-700">8. Lancer la commande finale</p>
                <div class="code-block-wrapper"><pre class="code-block"><code class="language-bash">php artisan migrate:fresh --seed</code></pre><button class="copy-btn">Copier</button></div>
            </div>
        </div>
    </section>

    <div class="text-right mt-8"> <a href="#page-top" class="text-sm font-semibold text-blue-600 hover:underline">↑ Retour en haut</a> </div>
</section>
<!-- ========== CHAPITRE 5 : ELOQUENT – LES BASES ========== -->
<section id="eloquent-bases" class="mb-16">
    <h3 class="text-2xl font-semibold mb-3">Chapitre 5 : Eloquent – Les Bases (CRUD)</h3>
    <p class="text-xl text-gray-600 mb-8 leading-relaxed">Nous avons une structure de base de données solide grâce aux migrations. Il est maintenant temps d'interagir avec elle. Eloquent est l'ORM (Object-Relational Mapper) de Laravel. C'est un traducteur intelligent qui vous permet de dialoguer avec vos tables SQL en utilisant des objets PHP, sans écrire une seule ligne de SQL (ou presque). Ce chapitre couvre les opérations fondamentales : Créer, Lire, Mettre à jour et Supprimer des données (CRUD).</p>
    
    <div class="bg-white p-6 rounded-lg shadow-sm border space-y-8 mt-8">
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">5.1. Le Modèle Eloquent : Votre Représentant de Table</h4>
            <p class="text-gray-700 mb-4">Le cœur d'Eloquent est le **Modèle**. Chaque modèle que vous créez dans votre dossier `app/Models/` est directement lié à une table dans votre base de données. Laravel utilise des conventions pour simplifier cette liaison :</p>
            <ul class="list-disc ml-6 text-gray-600 space-y-2 mb-4">
                <li>Un modèle `Product` correspondra à la table `products`.</li>
                <li>Un modèle `ProductCategory` correspondra à la table `product_categories`.</li>
            </ul>
            <p class="text-gray-700 mb-4">Nous avons déjà créé nos modèles `Product` et `Category` à l'étape précédente. Un modèle vide est déjà fonctionnel, mais pour des raisons de sécurité, nous devons y ajouter une propriété essentielle.</p>
        </div>

        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">5.2. Sécurité : La Protection contre l'Assignation de Masse (`Mass Assignment`)</h4>
            <p class="text-gray-700 mb-4">Imaginez que vous permettez à un utilisateur de s'inscrire avec un nom et un email. Si un utilisateur malveillant ajoute `is_admin=1` dans les données envoyées, la méthode `User::create($request->all())` pourrait accidentellement lui donner des droits administrateur. C'est une faille de "Mass Assignment".</p>
            <p class="text-gray-700 mb-4">Pour éviter cela, Laravel exige que vous déclariez explicitement quels champs de votre table peuvent être remplis via des méthodes comme `create()` ou `update()`. C'est le rôle de la propriété `$fillable`.</p>
            <div class="code-block-wrapper">
                <pre class="code-block"><code class="language-php"><span class="token-comment">// Fichier : app/Models/Product.php</span>
<span class="token-preprocessor"><?php</span>
<span class="token-keyword">namespace</span> <span class="token-namespace">App\Models</span>;

<span class="token-keyword">use</span> <span class="token-class-name">Illuminate\Database\Eloquent\Factories\HasFactory</span>;
<span class="token-keyword">use</span> <span class="token-class-name">Illuminate\Database\Eloquent\Model</span>;

<span class="token-keyword">class</span> <span class="token-class-name">Product</span> <span class="token-keyword">extends</span> <span class="token-class-name">Model</span>
{
    <span class="token-keyword">use</span> HasFactory;

    <span class="token-comment">/**
     * The attributes that are mass assignable.
     *
     * @var array
     */</span>
    <span class="token-keyword">protected</span> <span class="token-variable">$fillable</span> = [
        <span class="token-string">'name'</span>,
        <span class="token-string">'description'</span>,
        <span class="token-string">'price'</span>,
        <span class="token-string">'stock'</span>,
        <span class="token-string">'is_active'</span>,
        <span class="token-string">'category_id'</span>,
    ];
}
</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
            <p class="text-gray-700 mt-4">Désormais, seules les colonnes listées dans `$fillable` pourront être assignées en masse, protégeant ainsi votre application.</p>
        </div>
        
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">5.3. Lire les Données (Read)</h4>
            <p class="text-gray-700 mb-4">C'est l'opération la plus courante. Eloquent la rend incroyablement simple.</p>
            <div class="code-block-wrapper">
                <pre class="code-block"><code class="language-php"><span class="token-keyword">use</span> <span class="token-class-name">App\Models\Product</span>;

<span class="token-comment">// 1. Récupérer TOUS les produits</span>
<span class="token-variable">$products</span> = Product::<span class="token-function">all</span>(); <span class="token-comment">// Renvoie une Collection d'objets Product</span>

<span class="token-comment">// 2. Trouver un produit par sa clé primaire (id)</span>
<span class="token-variable">$product</span> = Product::<span class="token-function">find</span>(<span class="token-number">5</span>); <span class="token-comment">// Renvoie un seul objet Product, ou null s'il n'est pas trouvé</span>

<span class="token-comment">// 3. Trouver un produit ou échouer (génère une erreur 404 si non trouvé) - MEILLEURE PRATIQUE</span>
<span class="token-variable">$product</span> = Product::<span class="token-function">findOrFail</span>(<span class="token-number">5</span>);

<span class="token-comment">// 4. Construire une requête plus complexe</span>
<span class="token-variable">$activeProducts</span> = Product::<span class="token-function">where</span>(<span class="token-string">'is_active'</span>, <span class="token-keyword">true</span>)
                           -><span class="token-function">orderBy</span>(<span class="token-string">'price'</span>, <span class="token-string">'desc'</span>)
                           -><span class="token-function">take</span>(<span class="token-number">10</span>)
                           -><span class="token-function">get</span>(); <span class="token-comment">// ->get() exécute la requête et renvoie une Collection</span>

<span class="token-comment">// 5. Obtenir le premier résultat d'une requête</span>
<span class="token-variable">$firstExpensiveProduct</span> = Product::<span class="token-function">where</span>(<span class="token-string">'price'</span>, <span class="token-string">'>'</span>, <span class="token-number">500</span>)-><span class="token-function">first</span>();
</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
        </div>

        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">5.4. Créer, Mettre à Jour & Supprimer (C-U-D)</h4>
            <p class="text-gray-700 mb-4">Ces opérations sont tout aussi intuitives.</p>
             <div class="code-block-wrapper">
                <pre class="code-block"><code class="language-php"><span class="token-keyword">use</span> <span class="token-class-name">App\Models\Product</span>;

<span class="token-comment">// --- CRÉER un enregistrement (Create) ---</span>

<span class="token-comment">// Méthode 1: En utilisant `create` (nécessite la propriété $fillable)</span>
<span class="token-variable">$newProduct</span> = Product::<span class="token-function">create</span>([
    <span class="token-string">'name'</span> => <span class="token-string">'Nouveau Clavier Mécanique'</span>,
    <span class="token-string">'price'</span> => <span class="token-number">149.99</span>,
    <span class="token-string">'stock'</span> => <span class="token-number">150</span>,
    <span class="token-string">'category_id'</span> => <span class="token-number">1</span>
]);

<span class="token-comment">// --- METTRE À JOUR un enregistrement (Update) ---</span>

<span class="token-comment">// Méthode 1: Trouver, modifier, puis sauvegarder</span>
<span class="token-variable">$productToUpdate</span> = Product::<span class="token-function">findOrFail</span>(<span class="token-number">10</span>);
<span class="token-variable">$productToUpdate</span>->stock = <span class="token-number">75</span>;
<span class="token-variable">$productToUpdate</span>->is_active = <span class="token-keyword">false</span>;
<span class="token-variable">$productToUpdate</span>-><span class="token-function">save</span>();

<span class="token-comment">// Méthode 2: Mise à jour en masse (Mass Update)</span>
Product::<span class="token-function">where</span>(<span class="token-string">'stock'</span>, <span class="token-string">'&lt;'</span>, <span class="token-number">10</span>)-><span class="token-function">update</span>([<span class="token-string">'is_active'</span> => <span class="token-keyword">false</span>]);

<span class="token-comment">// --- SUPPRIMER un enregistrement (Delete) ---</span>

<span class="token-comment">// Méthode 1: Trouver puis supprimer</span>
<span class="token-variable">$productToDelete</span> = Product::<span class="token-function">findOrFail</span>(<span class="token-number">20</span>);
<span class="token-variable">$productToDelete</span>-><span class="token-function">delete</span>();

<span class="token-comment">// Méthode 2: Suppression par clé primaire</span>
Product::<span class="token-function">destroy</span>(<span class="token-number">21</span>);

<span class="token-comment">// Méthode 3: Suppression en masse</span>
Product::<span class="token-function">where</span>(<span class="token-string">'is_active'</span>, <span class="token-keyword">false</span>)-><span class="token-function">delete</span>();
</code></pre>
                <button class="copy-btn">Copier</button>
            </div>
        </div>
    </div>
    
    <!-- ========== ATELIER PRATIQUE  ========== -->
    <section id="exercices-partie2-chap5" class="mb-16 mt-12">
        <h3 class="text-2xl font-semibold mb-3">Atelier Pratique : Afficher la Liste des Produits</h3>
        <p class="text-gray-700 mb-8">Il est temps de connecter toutes les pièces. Nous allons créer notre première page dynamique : la liste des produits, récupérée directement depuis la base de données grâce à Eloquent.</p>
        
        <div class="bg-white p-6 rounded-lg shadow-sm border space-y-6">
            <h4 class="text-xl font-bold text-gray-800 mb-2">Mise en place de la page de liste des produits</h4>
            
            <p class="font-semibold text-gray-700">1. Créer le `ProductController`</p>
            <div class="code-block-wrapper"><pre class="code-block"><code class="language-bash"><span class="token-comment"># L'option --resource génère un contrôleur avec les méthodes standards du CRUD (index, create, store, etc.)</span>
php artisan make:controller ProductController --resource
</code></pre><button class="copy-btn">Copier</button></div>

            <p class="font-semibold text-gray-700">2. Définir la route dans `routes/web.php`</p>
             <div class="code-block-wrapper"><pre class="code-block"><code class="language-php"><span class="token-keyword">use</span> <span class="token-class-name">App\Http\Controllers\ProductController</span>;

<span class="token-comment">// Cette seule ligne crée toutes les routes nécessaires pour un CRUD complet sur les produits.</span>
Route::<span class="token-function">resource</span>(<span class="token-string">'products'</span>, ProductController::<span class="token-keyword">class</span>);
</code></pre><button class="copy-btn">Copier</button></div>
             <p class="text-gray-700">Vous pouvez voir la liste des routes créées avec la commande `php artisan route:list`.</p>

            <p class="font-semibold text-gray-700">3. Remplir la méthode `index` du `ProductController`</p>
            <div class="code-block-wrapper"><pre class="code-block"><code class="language-php"><span class="token-comment">// Fichier: app/Http/Controllers/ProductController.php</span>
<span class="token-keyword">use</span> <span class="token-class-name">App\Models\Product</span>;
<span class="token-keyword">use</span> <span class="token-class-name">Illuminate\View\View</span>;

<span class="token-keyword">public</span> <span class="token-keyword">function</span> <span class="token-function">index</span>(): View
{
    <span class="token-variable">$products</span> = Product::<span class="token-function">all</span>(); <span class="token-comment">// On récupère tous les produits</span>
    
    <span class="token-keyword">return</span> <span class="token-function">view</span>(<span class="token-string">'products.index'</span>, [<span class="token-string">'products'</span> => <span class="token-variable">$products</span>]);
}
</code></pre><button class="copy-btn">Copier</button></div>
            <p class="text-gray-700">Le nom de la vue `products.index` correspond au fichier `resources/views/products/index.blade.php`.</p>

            <p class="font-semibold text-gray-700">4. Créer la Vue (`resources/views/products/index.blade.php`)</p>
            <p class="text-gray-700">Créez un dossier `products` dans `resources/views`, puis le fichier `index.blade.php` à l'intérieur.</p>
            <div class="code-block-wrapper"><pre class="code-block"><code class="language-html">&lt;!DOCTYPE html>
&lt;html lang="fr">
&lt;head>&lt;title>Liste des Produits&lt;/title>&lt;/head>
&lt;body>
    &lt;h1>Nos Produits&lt;/h1>
    &lt;ul>
        <span class="token-preprocessor">@foreach</span> (<span class="token-variable">$products</span> as <span class="token-variable">$product</span>)
            &lt;li>
                {{ <span class="token-variable">$product</span>->name }} - {{ <span class="token-variable">$product</span>->price }} €
            &lt;/li>
        <span class="token-preprocessor">@endforeach</span>
    &lt;/ul>
&lt;/body>
&lt;/html>
</code></pre><button class="copy-btn">Copier</button></div>
             <p class="text-gray-700 mt-4">Maintenant, visitez `http://127.0.0.1:8000/products`. La liste des 50 produits de votre base de données doit s'afficher !</p>
        </div>

        <div class="mt-8 p-6 bg-blue-50 border-l-4 border-blue-500">
            <h4 class="text-xl font-bold text-gray-800 mb-2">Exercice : Créer la page de détail d'un produit</h4>
            <p class="text-gray-700 mb-4">Votre mission est de rendre la page de détail d'un produit accessible. Par exemple, l'URL `/products/5` devra afficher toutes les informations du produit qui a l'ID 5.</p>
            
            <button class="solution-toggle">Voir la solution</button>
            <div class="solution-content space-y-6">
                <p class="font-semibold text-gray-700 mt-4">1. Remplir la méthode `show` du `ProductController`</p>
                <div class="code-block-wrapper"><pre class="code-block"><code class="language-php"><span class="token-comment">// La route `Route::resource` a déjà défini que cette méthode recevra l'ID du produit.</span>
<span class="token-comment">// Mieux encore, Laravel peut automatiquement trouver le produit pour nous (Route Model Binding).</span>
<span class="token-keyword">public</span> <span class="token-keyword">function</span> <span class="token-function">show</span>(Product <span class="token-variable">$product</span>): View
{
    <span class="token-comment">// Pas besoin de faire `Product::findOrFail($id)` ! Laravel le fait pour nous.</span>
    <span class="token-keyword">return</span> <span class="token-function">view</span>(<span class="token-string">'products.show'</span>, [<span class="token-string">'product'</span> => <span class="token-variable">$product</span>]);
}
</code></pre><button class="copy-btn">Copier</button></div>

                <p class="font-semibold text-gray-700">2. Créer la Vue (`resources/views/products/show.blade.php`)</p>
                 <div class="code-block-wrapper"><pre class="code-block"><code class="language-html">&lt;!DOCTYPE html>
&lt;html lang="fr">
&lt;head>&lt;title>{{ <span class="token-variable">$product</span>->name }}&lt;/title>&lt;/head>
&lt;body>
    &lt;h1>{{ <span class="token-variable">$product</span>->name }}&lt;/h1>
    &lt;p><strong>Description :</strong> {{ <span class="token-variable">$product</span>->description }}&lt;/p>
    &lt;p><strong>Prix :</strong> {{ <span class="token-variable">$product</span>->price }} €&lt;/p>
    &lt;p><strong>Stock :</strong> {{ <span class="token-variable">$product</span>->stock }} unités&lt;/p>
    
    &lt;a href="/products">Retour à la liste&lt;/a>
&lt;/body>
&lt;/html>
</code></pre><button class="copy-btn">Copier</button></div>

                 <p class="font-semibold text-gray-700 mt-4">3. Mettre à jour la liste pour inclure les liens</p>
                 <p class="text-gray-700">Modifiez `products/index.blade.php` pour que chaque produit soit un lien vers sa page de détail.</p>
                 <div class="code-block-wrapper"><pre class="code-block"><code class="language-html"><span class="token-comment">&lt;!-- ... dans la boucle @foreach de index.blade.php --></span>
&lt;li>
    &lt;a href="/products/{{ <span class="token-variable">$product</span>->id }}">
        {{ <span class="token-variable">$product</span>->name }}
    &lt;/a> 
    - {{ <span class="token-variable">$product</span>->price }} €
&lt;/li>
</code></pre><button class="copy-btn">Copier</button></div>
                 <p class="text-gray-700 mt-4">Maintenant, sur la page `/products`, vous pouvez cliquer sur n'importe quel produit pour voir sa page de détail.</p>
            </div>
        </div>
    </section>

    <div class="text-right mt-8"> <a href="#page-top" class="text-sm font-semibold text-blue-600 hover:underline">↑ Retour en haut</a> </div>
</section>
<!-- ========== CHAPITRE 6 : ELOQUENT – AVANCÉ (RELATIONS & SCOPES) ========== -->
<section id="eloquent-avance" class="mb-16">
    <h3 class="text-2xl font-semibold mb-3">Chapitre 6 : Eloquent – Avancé (Relations, Scopes & Accessors)</h3>
    <p class="text-xl text-gray-600 mb-8 leading-relaxed">Maintenant que nous savons manipuler une table, il est temps de gérer ce qui fait la force d'une base de données : les liens entre les tables. Ce chapitre est consacré aux **relations Eloquent**. Nous apprendrons à définir et à utiliser les relations entre nos modèles, à optimiser drastiquement nos requêtes pour éviter des problèmes de performance, et à écrire un code plus propre et réutilisable grâce aux Scopes et aux Accessors.</p>
    
    <div class="bg-white p-6 rounded-lg shadow-sm border space-y-8 mt-8">
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">6.1. Définir les Relations : `belongsTo` et `hasMany`</h4>
            <p class="text-gray-700 mb-4">Nous avons une colonne `category_id` dans notre table `products`. Pour qu'Eloquent comprenne ce lien, nous devons le déclarer dans nos modèles. C'est une relation "Un-à-Plusieurs" (One-to-Many) : une catégorie **a plusieurs** produits, et un produit **appartient à** une seule catégorie.</p>
            
            <p class="font-semibold text-gray-700">1. La relation `belongsTo` (appartient à) dans le modèle `Product`</p>
            <div class="code-block-wrapper"><pre class="code-block"><code class="language-php"><span class="token-comment">// Fichier: app/Models/Product.php</span>
<span class="token-keyword">use</span> <span class="token-class-name">Illuminate\Database\Eloquent\Relations\BelongsTo</span>;

<span class="token-keyword">class</span> <span class="token-class-name">Product</span> <span class="token-keyword">extends</span> <span class="token-class-name">Model</span>
{
    <span class="token-comment">// ...</span>
    <span class="token-keyword">public</span> <span class="token-keyword">function</span> <span class="token-function">category</span>(): BelongsTo
    {
        <span class="token-keyword">return</span> <span class="token-variable">$this</span>-><span class="token-function">belongsTo</span>(Category::<span class="token-keyword">class</span>);
    }
}
</code></pre><button class="copy-btn">Copier</button></div>

            <p class="font-semibold text-gray-700 mt-4">2. La relation `hasMany` (a plusieurs) dans le modèle `Category`</p>
            <div class="code-block-wrapper"><pre class="code-block"><code class="language-php"><span class="token-comment">// Fichier: app/Models/Category.php</span>
<span class="token-keyword">use</span> <span class="token-class-name">Illuminate\Database\Eloquent\Relations\HasMany</span>;

<span class="token-keyword">class</span> <span class="token-class-name">Category</span> <span class="token-keyword">extends</span> <span class="token-class-name">Model</span>
{
    <span class="token-comment">// ...</span>
    <span class="token-keyword">protected</span> <span class="token-variable">$fillable</span> = [<span class="token-string">'name'</span>];

    <span class="token-keyword">public</span> <span class="token-keyword">function</span> <span class="token-function">products</span>(): HasMany
    {
        <span class="token-keyword">return</span> <span class="token-variable">$this</span>-><span class="token-function">hasMany</span>(Product::<span class="token-keyword">class</span>);
    }
}
</code></pre><button class="copy-btn">Copier</button></div>
             <p class="text-gray-700 mt-4">Maintenant, nous pouvons naviguer dans nos données de manière totalement intuitive :</p>
              <div class="code-block-wrapper"><pre class="code-block"><code class="language-php"><span class="token-variable">$product</span> = Product::<span class="token-function">find</span>(<span class="token-number">1</span>);
<span class="token-keyword">echo</span> <span class="token-variable">$product</span>->category->name; <span class="token-comment">// Accède au nom de la catégorie du produit</span>

<span class="token-variable">$category</span> = Category::<span class="token-function">find</span>(<span class="token-number">1</span>);
<span class="token-keyword">foreach</span> (<span class="token-variable">$category</span>->products as <span class="token-variable">$product</span>) { <span class="token-keyword">echo</span> <span class="token-variable">$product</span>->name; }
</code></pre><button class="copy-btn">Copier</button></div>
        </div>

        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">6.2. Le Problème N+1 et l'Eager Loading</h4>
            <p class="text-gray-700 mb-4">C'est **le concept le plus important de ce chapitre**. Utiliser les relations de manière naïve peut détruire les performances. Si vous affichez une liste de 50 produits et leur catégorie dans une boucle (`$product->category->name`), Laravel exécutera **51 requêtes SQL** (1 pour les produits + 50 pour chaque catégorie). C'est le problème N+1.</p>

            <p class="font-semibold text-gray-700">La solution : Eager Loading (Chargement anticipé)</p>
            <p class="text-gray-700 mb-4">On dit à Eloquent de charger les relations à l'avance avec la méthode `with()`.</p>
             <div class="code-block-wrapper"><pre class="code-block"><code class="language-php"><span class="token-comment">// Ce code exécute 2 requêtes au lieu de 51. C'est infiniment plus performant.</span>
<span class="token-variable">$products</span> = Product::<span class="token-function">with</span>(<span class="token-string">'category'</span>)-><span class="token-function">get</span>();
</code></pre><button class="copy-btn">Copier</button></div>
            <p class="text-gray-700 mt-4">**Prenez l'habitude d'utiliser `with()` systématiquement lorsque vous accédez à des relations dans une boucle.**</p>
        </div>

        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">6.3. Query Scopes : Rendre vos Requêtes Réutilisables</h4>
            <p class="text-gray-700 mb-4">Au lieu de réécrire `->where('is_active', true)` partout, vous pouvez créer un raccourci dans votre modèle appelé **Scope**.</p>
            <div class="code-block-wrapper"><pre class="code-block"><code class="language-php"><span class="token-comment">// Fichier: app/Models/Product.php</span>
<span class="token-keyword">public</span> <span class="token-keyword">function</span> <span class="token-function">scopeActive</span>(Builder <span class="token-variable">$query</span>): <span class="token-keyword">void</span>
{
    <span class="token-variable">$query</span>-><span class="token-function">where</span>(<span class="token-string">'is_active'</span>, <span class="token-keyword">true</span>);
}
</code></pre><button class="copy-btn">Copier</button></div>
            <p class="text-gray-700 mt-4">Utilisation : `Product::active()->get();`</p>
        </div>

        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">6.4. Accessors & Mutators : Transformer les Données</h4>
            <p class="text-gray-700 mb-4">Ce sont des "méthodes magiques" pour formater les attributs de vos modèles. Un **Accessor** (`get`) formate une donnée pour l'affichage. Un **Mutator** (`set`) la transforme avant de la sauvegarder.</p>
            <div class="code-block-wrapper"><pre class="code-block"><code class="language-php"><span class="token-comment">// Fichier: app/Models/Product.php</span>
<span class="token-keyword">protected</span> <span class="token-keyword">function</span> <span class="token-function">name</span>(): Attribute
{
    <span class="token-keyword">return</span> Attribute::<span class="token-function">make</span>(
        get: fn (<span class="token-variable">$value</span>) => <span class="token-function">strtoupper</span>(<span class="token-variable">$value</span>), <span class="token-comment">// Toujours afficher en majuscules</span>
        set: fn (<span class="token-variable">$value</span>) => <span class="token-function">ucfirst</span>(<span class="token-function">strtolower</span>(<span class="token-variable">$value</span>)), <span class="token-comment">// Toujours sauvegarder avec une capitale</span>
    );
}
</code></pre><button class="copy-btn">Copier</button></div>
        </div>
        
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">6.5. Relation Un-à-Un (`hasOne`)</h4>
            <p class="text-gray-700 mb-4"><strong>Analogie :</strong> Un produit a une seule fiche de détails techniques. Nous allons créer une table `product_details` pour cela.</p>
            <p class="font-semibold text-gray-700">Atelier : Créer la table des détails de produits</p>
            <p class="text-gray-700 mb-4">1. Créez le modèle `ProductDetail` avec sa migration : `php artisan make:model ProductDetail -m`</p>
            <p class="text-gray-700 mb-4">2. Modifiez la migration pour y inclure une clé étrangère **unique**.</p>
            <div class="code-block-wrapper"><pre class="code-block"><code class="language-php">Schema::create('product_details', function (Blueprint $table) {
    $table->id();
    $table->foreignId('product_id')->unique()->constrained()->onDelete('cascade');
    $table->string('part_number'); $table->float('weight_kg');
    $table->timestamps();
});
</code></pre><button class="copy-btn">Copier</button></div>
            <p class="text-gray-700 mt-4 mb-4">3. Définissez les relations dans les modèles.</p>
            <div class="code-block-wrapper"><pre class="code-block"><code class="language-php"><span class="token-comment">// Fichier: app/Models/Product.php</span>
public function detail(): HasOne { return $this->hasOne(ProductDetail::class); }

<span class="token-comment">// Fichier: app/Models/ProductDetail.php</span>
public function product(): BelongsTo { return $this->belongsTo(Product::class); }
</code></pre><button class="copy-btn">Copier</button></div>
        </div>
        
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">6.6. Relation Plusieurs-à-Plusieurs (`belongsToMany`)</h4>
            <p class="text-gray-700 mb-4"><strong>Analogie :</strong> Un produit peut être vendu par plusieurs fournisseurs. Nous avons besoin d'une table intermédiaire (pivot) `product_supplier`.</p>
            <p class="font-semibold text-gray-700">Atelier : Lier les produits et les fournisseurs</p>
            <p class="text-gray-700 mb-4">1. Créez le modèle `Supplier` et sa migration : `php artisan make:model Supplier -m`</p>
            <p class="text-gray-700 mb-4">2. Créez la migration pour la table pivot : `php artisan make:migration create_product_supplier_pivot_table`</p>
            <p class="text-gray-700 mb-4">3. Remplissez les migrations et définissez les relations.</p>
            <div class="code-block-wrapper"><pre class="code-block"><code class="language-php"><span class="token-comment">// Migration `create_suppliers_table` -> $table->string('name');</span>

<span class="token-comment">// Migration `create_product_supplier_pivot_table`</span>
Schema::create('product_supplier', function (Blueprint $table) {
    $table->primary(['product_id', 'supplier_id']);
    $table->foreignId('product_id')->constrained()->onDelete('cascade');
    $table->foreignId('supplier_id')->constrained()->onDelete('cascade');
});

<span class="token-comment">// Modèle Product.php</span>
public function suppliers(): BelongsToMany { return $this->belongsToMany(Supplier::class); }

<span class="token-comment">// Modèle Supplier.php</span>
public function products(): BelongsToMany { return $this->belongsToMany(Product::class); }
</code></pre><button class="copy-btn">Copier</button></div>
        </div>

        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">6.7. Relations Polymorphes (Les "Caméléons")</h4>
            <p class="text-gray-700 mb-4"><strong>Analogie :</strong> Imaginez que vous voulez attacher des images à des produits, mais aussi à des catégories. Une relation polymorphe permet à votre modèle `Image` d'appartenir à n'importe quel autre modèle.</p>
            <p class="font-semibold text-gray-700">Atelier : Attacher des images aux produits ET aux catégories</p>
            <p class="text-gray-700 mb-4">1. Créez le modèle `Image` et sa migration : `php artisan make:model Image -m`</p>
            <p class="text-gray-700 mb-4">2. Dans la migration, utilisez la méthode `morphs()`.</p>
            <div class="code-block-wrapper"><pre class="code-block"><code class="language-php">Schema::create('images', function (Blueprint $table) {
    $table->id();
    $table->string('url');
    $table->morphs('imageable'); // Crée `imageable_id` et `imageable_type`
    $table->timestamps();
});
</code></pre><button class="copy-btn">Copier</button></div>
            <p class="text-gray-700 mt-4 mb-4">3. Définissez les relations.</p>
            <div class="code-block-wrapper"><pre class="code-block"><code class="language-php"><span class="token-comment">// Fichier: app/Models/Image.php</span>
public function imageable(): MorphTo { return $this->morphTo(); }

<span class="token-comment">// Fichier: app/Models/Product.php ET app/Models/Category.php</span>
public function images(): MorphMany { return $this->morphMany(Image::class, 'imageable'); }
</code></pre><button class="copy-btn">Copier</button></div>
        </div>
    </div>
    
    <!-- ========== ATELIER PRATIQUE  ========== -->
    <section id="exercices-partie2-chap6" class="mb-16 mt-12">
        <h3 class="text-2xl font-semibold mb-3">Atelier Pratique : Afficher les Produits par Catégorie</h3>
        <p class="text-gray-700 mb-8">Nous allons mettre en pratique ces nouveaux concepts en créant une page qui affiche une catégorie et tous les produits qui lui sont associés.</p>
        
        <div class="bg-white p-6 rounded-lg shadow-sm border space-y-6">
            <h4 class="text-xl font-bold text-gray-800 mb-2">Mise en place de la page de liste des catégories</h4>
            <p class="font-semibold text-gray-700">1. Créer le `CategoryController` et les routes</p>
            <div class="code-block-wrapper"><pre class="code-block"><code class="language-bash">php artisan make:controller CategoryController --resource
</code></pre><button class="copy-btn">Copier</button></div>
             <div class="code-block-wrapper"><pre class="code-block"><code class="language-php"><span class="token-comment">// Fichier: routes/web.php</span>
Route::<span class="token-function">resource</span>(<span class="token-string">'categories'</span>, CategoryController::<span class="token-keyword">class</span>);
</code></pre><button class="copy-btn">Copier</button></div>

            <p class="font-semibold text-gray-700">2. Remplir la méthode `show` du `CategoryController` avec Eager Loading</p>
            <div class="code-block-wrapper"><pre class="code-block"><code class="language-php"><span class="token-comment">// Fichier: app/Http/Controllers/CategoryController.php</span>
<span class="token-keyword">public</span> <span class="token-keyword">function</span> <span class="token-function">show</span>(Category <span class="token-variable">$category</span>): View
{
    <span class="token-variable">$category</span>-><span class="token-function">load</span>(<span class="token-string">'products'</span>);
    <span class="token-keyword">return</span> <span class="token-function">view</span>(<span class="token-string">'categories.show'</span>, [<span class="token-string">'category'</span> => <span class="token-variable">$category</span>]);
}
</code></pre><button class="copy-btn">Copier</button></div>

            <p class="font-semibold text-gray-700">3. Créer la Vue (`resources/views/categories/show.blade.php`)</p>
            <div class="code-block-wrapper"><pre class="code-block"><code class="language-html">&lt;h1>Produits de la catégorie : {{ <span class="token-variable">$category</span>->name }}&lt;/h1>
&lt;ul>
    <span class="token-preprocessor">@forelse</span> (<span class="token-variable">$category</span>->products as <span class="token-variable">$product</span>)
        &lt;li>&lt;a href="/products/{{ <span class="token-variable">$product</span>->id }}">{{ <span class="token-variable">$product</span>->name }}&lt;/a>&lt;/li>
    <span class="token-preprocessor">@empty</span>
        &lt;li>Aucun produit dans cette catégorie.&lt;/li>
    <span class="token-preprocessor">@endforelse</span>
&lt;/ul>
</code></pre><button class="copy-btn">Copier</button></div>
        </div>

        <div class="mt-8 p-6 bg-blue-50 border-l-4 border-blue-500">
            <h4 class="text-xl font-bold text-gray-800 mb-2">Exercice : Afficher les fournisseurs d'un produit</h4>
            <p class="text-gray-700 mb-4">Votre mission est de mettre en pratique la relation Many-to-Many en modifiant la page de détail d'un produit (`/products/{id}`) pour y afficher la liste de ses fournisseurs.</p>
            
            <button class="solution-toggle">Voir la solution</button>
            <div class="solution-content space-y-6">
                <p class="font-semibold text-gray-700 mt-4">1. Créer et peupler les fournisseurs</p>
                <p class="text-gray-700">Assurez-vous d'avoir les migrations pour `suppliers` et `product_supplier`, ainsi que les modèles et relations `belongsToMany` configurés.</p>
                <div class="code-block-wrapper"><pre class="code-block"><code class="language-bash">php artisan make:seeder SupplierSeeder</code></pre><button class="copy-btn">Copier</button></div>
                <p class="text-gray-700">Dans `SupplierSeeder.php`:</p>
                <div class="code-block-wrapper"><pre class="code-block"><code class="language-php">use App\Models\Supplier; use App\Models\Product;
public function run(): void
{
    $suppliers = Supplier::factory(10)->create();
    Product::all()->each(fn ($p) => $p->suppliers()->attach($suppliers->random(rand(1, 3))));
}
</code></pre><button class="copy-btn">Copier</button></div>
                <p class="text-gray-700">Appelez ce seeder dans `DatabaseSeeder.php` et lancez `php artisan migrate:fresh --seed`.</p>

                <p class="font-semibold text-gray-700">2. Modifiez la méthode `show` du `ProductController`</p>
                <div class="code-block-wrapper"><pre class="code-block"><code class="language-php">public function show(Product $product): View
{
    $product->load(['category', 'suppliers']);
    return view('products.show', ['product' => $product]);
}
</code></pre><button class="copy-btn">Copier</button></div>

                <p class="font-semibold text-gray-700">3. Mettez à jour la vue `products.show.blade.php`</p>
                <div class="code-block-wrapper"><pre class="code-block"><code class="language-html">&lt;h2>Fournisseurs&lt;/h2>
&lt;ul>
    <span class="token-preprocessor">@forelse</span> ($product->suppliers as $supplier) &lt;li>{{ $supplier->name }}&lt;/li>
    <span class="token-preprocessor">@empty</span> &lt;li>Aucun fournisseur.&lt;/li> <span class="token-preprocessor">@endforelse</span>
&lt;/ul>
</code></pre><button class="copy-btn">Copier</button></div>
            </div>
        </div>
    </section>

    <div class="text-right mt-8"> <a href="#page-top" class="text-sm font-semibold text-blue-600 hover:underline">↑ Retour en haut</a> </div>
</section>
<!-- ========== ATELIERS & EXERCICES COMPLÉMENTAIRES ========== -->
<section id="exercices-partie2-chap6-suite" class="mb-16 mt-12">
    <h3 class="text-2xl font-semibold mb-3">Ateliers & Exercices Complémentaires</h3>
    <p class="text-gray-700 mb-8">Pour maîtriser pleinement la puissance d'Eloquent, nous allons maintenant mettre en pratique les autres types de relations et de fonctionnalités que nous avons découverts.</p>
    
    <!-- Atelier HasOne -->
    <div class="bg-white p-6 rounded-lg shadow-sm border space-y-6 mb-8">
        <h4 class="text-xl font-bold text-gray-800 mb-2">Atelier Guidé : Afficher les Détails Techniques (`hasOne`)</h4>
        <p class="text-gray-700 mb-4">Notre table `product_details` est prête, mais elle est vide. Nous allons la peupler et afficher ses informations sur la page de détail du produit.</p>
        
        <p class="font-semibold text-gray-700">1. Créer une Factory pour `ProductDetail`</p>
        <div class="code-block-wrapper"><pre class="code-block"><code class="language-bash">php artisan make:factory ProductDetailFactory</code></pre><button class="copy-btn">Copier</button></div>
        <p class="text-gray-700 mt-4">Remplissez la factory (`database/factories/ProductDetailFactory.php`):</p>
        <div class="code-block-wrapper"><pre class="code-block"><code class="language-php"><span class="token-keyword">public</span> <span class="token-keyword">function</span> <span class="token-function">definition</span>(): array
{
    <span class="token-keyword">return</span> [
        <span class="token-string">'part_number'</span> => <span class="token-variable">$this</span>->faker-><span class="token-function">bothify</span>(<span class="token-string">'PN-####-??'</span>),
        <span class="token-string">'weight_kg'</span> => <span class="token-variable">$this</span>->faker-><span class="token-function">randomFloat</span>(<span class="token-number">2</span>, <span class="token-number">0.1</span>, <span class="token-number">25</span>),
    ];
}
</code></pre><button class="copy-btn">Copier</button></div>

        <p class="font-semibold text-gray-700 mt-4">2. Créer un Seeder pour peupler les détails</p>
        <div class="code-block-wrapper"><pre class="code-block"><code class="language-bash">php artisan make:seeder ProductDetailSeeder</code></pre><button class="copy-btn">Copier</button></div>
        <p class="text-gray-700 mt-4">Dans `ProductDetailSeeder.php`, nous allons créer un détail pour chaque produit existant :</p>
        <div class="code-block-wrapper"><pre class="code-block"><code class="language-php">use App\Models\Product;
use App\Models\ProductDetail;

public function run(): void
{
    Product::all()->each(function ($product) {
        ProductDetail::factory()->create(['product_id' => $product->id]);
    });
}
</code></pre><button class="copy-btn">Copier</button></div>
        <p class="text-gray-700 mt-4">N'oubliez pas d'appeler `ProductDetailSeeder::class` dans `DatabaseSeeder.php` et de lancer `php artisan migrate:fresh --seed`.</p>

        <p class="font-semibold text-gray-700 mt-4">3. Mettre à jour `ProductController@show` et la Vue</p>
        <p class="text-gray-700">Ajoutez `'detail'` à l'Eager Loading dans le contrôleur : `$product->load(['category', 'suppliers', 'detail']);`</p>
        <p class="text-gray-700 mt-4">Puis, dans `products/show.blade.php`, ajoutez cette section :</p>
        <div class="code-block-wrapper"><pre class="code-block"><code class="language-html"><span class="token-preprocessor">@if</span>(<span class="token-variable">$product</span>->detail)
    &lt;h2>Détails Techniques&lt;/h2>
    &lt;ul>
        &lt;li>Numéro de pièce : {{ <span class="token-variable">$product</span>->detail->part_number }}&lt;/li>
        &lt;li>Poids : {{ <span class="token-variable">$product</span>->detail->weight_kg }} kg&lt;/li>
    &lt;/ul>
<span class="token-preprocessor">@endif</span>
</code></pre><button class="copy-btn">Copier</button></div>
    </div>

    <!-- Exercice Accessor -->
    <div class="mt-8 p-6 bg-blue-50 border-l-4 border-blue-500">
        <h4 class="text-xl font-bold text-gray-800 mb-2">Exercice : Formater le Prix avec un Accessor</h4>
        <p class="text-gray-700 mb-4">Actuellement, un prix de `1299.99` s'affiche tel quel. Votre mission est de créer un **attribut virtuel** `formatted_price` sur le modèle `Product` qui retourne le prix formaté en euros avec deux décimales et un séparateur de milliers (ex: "1 299,99 €").</p>
        
        <button class="solution-toggle">Voir la solution</button>
        <div class="solution-content space-y-6">
            <p class="font-semibold text-gray-700 mt-4">1. Créer l'Accessor dans le modèle `Product`</p>
            <p class="text-gray-700">Ajoutez cette méthode dans `app/Models/Product.php`. Nous créons un nouvel attribut qui n'existe pas en base de données.</p>
            <div class="code-block-wrapper"><pre class="code-block"><code class="language-php">use Illuminate\Database\Eloquent\Casts\Attribute;

// ... dans la classe Product

protected function formattedPrice(): Attribute
{
    return Attribute::make(
        get: fn () => number_format($this->price, 2, ',', ' ') . ' €'
    );
}
</code></pre><button class="copy-btn">Copier</button></div>

            <p class="font-semibold text-gray-700 mt-4">2. Utiliser le nouvel attribut dans les vues</p>
            <p class="text-gray-700">Modifiez `products/index.blade.php` et `products/show.blade.php`. Remplacez `{{ $product->price }} €` par :</p>
            <div class="code-block-wrapper"><pre class="code-block"><code class="language-html">{{ $product->formatted_price }}
</code></pre><button class="copy-btn">Copier</button></div>
            <p class="text-gray-700 mt-4">Notez que Laravel convertit automatiquement l'appel à la méthode camelCase `formattedPrice()` en un attribut snake_case `formatted_price`. Rafraîchissez vos pages pour voir la nouvelle mise en forme !</p>
        </div>
    </div>

    <!-- Atelier Polymorphic -->
    <div class="bg-white p-6 rounded-lg shadow-sm border space-y-6 mt-8">
        <h4 class="text-xl font-bold text-gray-800 mb-2">Atelier Guidé : Gérer les Images (`Polymorphic`)</h4>
        <p class="text-gray-700 mb-4">Nous allons peupler notre table `images` et afficher les images sur les pages des produits et des catégories.</p>
        
        <p class="font-semibold text-gray-700">1. Créer Factory et Seeder pour les Images</p>
        <div class="code-block-wrapper"><pre class="code-block"><code class="language-bash">php artisan make:factory ImageFactory
php artisan make:seeder ImageSeeder
</code></pre><button class="copy-btn">Copier</button></div>
        <p class="text-gray-700 mt-4">Remplissez `ImageFactory.php`:</p>
        <div class="code-block-wrapper"><pre class="code-block"><code class="language-php">public function definition(): array
{
    return [ 'url' => $this->faker->imageUrl(640, 480, 'technics', true) ];
}
</code></pre><button class="copy-btn">Copier</button></div>
        <p class="text-gray-700 mt-4">Remplissez `ImageSeeder.php` pour attacher des images aux produits ET aux catégories :</p>
        <div class="code-block-wrapper"><pre class="code-block"><code class="language-php">use App\Models\Image;
use App\Models\Product;
use App\Models\Category;

public function run(): void
{
    // Attache 1 à 3 images à chaque produit
    Product::all()->each(function ($product) {
        $product->images()->saveMany(Image::factory(rand(1, 3))->make());
    });

    // Attache 1 image à chaque catégorie
    Category::all()->each(function ($category) {
        $category->images()->save(Image::factory()->make());
    });
}
</code></pre><button class="copy-btn">Copier</button></div>
        <p class="text-gray-700 mt-4">Appelez `ImageSeeder::class` dans `DatabaseSeeder.php` et lancez `php artisan migrate:fresh --seed`.</p>

        <p class="font-semibold text-gray-700 mt-4">2. Mettre à jour les Contrôleurs et les Vues</p>
        <p class="text-gray-700">Dans `ProductController@show`, ajoutez `'images'` à l'Eager Loading : `$product->load(['category', 'suppliers', 'detail', 'images']);`</p>
        <p class="text-gray-700 mt-4">Dans `products/show.blade.php`, ajoutez :</p>
        <div class="code-block-wrapper"><pre class="code-block"><code class="language-html">&lt;h2>Images&lt;/h2>
<span class="token-preprocessor">@forelse</span>(<span class="token-variable">$product</span>->images as <span class="token-variable">$image</span>)
    &lt;img src="{{ <span class="token-variable">$image</span>->url }}" alt="Image du produit" width="200">
<span class="token-preprocessor">@empty</span>
    &lt;p>Aucune image pour ce produit.&lt;/p>
<span class="token-preprocessor">@endforelse</span>
</code></pre><button class="copy-btn">Copier</button></div>
        <p class="text-gray-700 mt-4">Faites de même pour `CategoryController@show` et `categories/show.blade.php` pour valider que la relation polymorphe fonctionne des deux côtés !</p>
    </div>
</section>