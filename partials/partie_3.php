<?php
// Fichier : partie_3.php
// Titre : Partie 3 : Blade, Tailwind & Vite
?>

<!-- =================================================================== -->
<!-- PARTIE 3 : BLADE, TAILWIND & VITE -->
<!-- =================================================================== -->
<h2 class="text-3xl font-bold text-gray-800 border-b-2 border-gray-200 pb-2 mb-6">Partie 3 : Blade, Tailwind & Vite</h2>

<!-- ========== CHAPITRE 7 : BLADE AVANCÉ - ARCHITECTURE DES VUES ========== -->
<section id="blade-architecture" class="mb-16">
    <h3 class="text-2xl font-semibold mb-3">Chapitre 7 : Blade Avancé - Architecture des Vues</h3>
    <p class="text-xl text-gray-600 mb-8 leading-relaxed">Nous avons créé des vues fonctionnelles, mais elles souffrent d'un défaut majeur : la duplication de code. Chaque fichier contient l'intégralité de la structure HTML. Ce chapitre est dédié à la résolution de ce problème en explorant les deux approches architecturales de Blade : l'héritage de template avec <code>@extends</code> et la composition avec les composants de layout <code>&lt;x-layout&gt;</code>.</p>

    <!-- =================================================================== -->
    <!-- PARTIE 7.A : L'HÉRITAGE DE TEMPLATE AVEC @EXTENDS -->
    <!-- =================================================================== -->
    <div class="bg-white p-6 rounded-lg shadow-sm border space-y-8 mt-8">
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">Approche 1 : L'Héritage avec <code>@extends</code>, <code>@section</code> et <code>@yield</code></h4>
            <p class="text-gray-700 mb-4">C'est l'approche historique et la plus simple à comprendre pour organiser ses vues. Elle repose sur un principe d'héritage.</p>
            <p class="text-gray-700 mb-4"><strong>Analogie :</strong> Pensez à un document avec un en-tête et un pied de page prédéfinis (le layout). Chaque page que vous créez (la vue enfant) "hérite" de cette structure et se contente de remplir la zone de contenu principal. Le layout est un "cadre photo" rigide ; la vue enfant est la "photo" que l'on place dedans.</p>
        </div>

        <div>
            <h5 class="font-semibold text-gray-800 mb-2 mt-6">Atelier Guidé A : Refactoriser nos vues avec un Layout Principal</h4>
            <p class="font-semibold text-gray-700">Étape 1 : Créer le fichier de layout</p>
            <p class="text-gray-700 mb-4">Créez le dossier <code>resources/views/layouts</code>, puis le fichier <code>app.blade.php</code> à l'intérieur. Ce fichier contiendra toute notre structure HTML commune.</p>
            <div class="code-block-wrapper"><pre class="code-block"><code class="language-html"><?= htmlspecialchars(
'<!DOCTYPE html>
<html lang="{{ str_replace(\'_\', \'-\', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield(\'title\', \'Application Commerciale\')</title>
    @vite([\'resources/css/app.css\', \'resources/js/app.js\'])
</head>
<body class="bg-gray-100">
    <header class="bg-white shadow-md p-4">
        <h1 class="text-2xl font-bold text-gray-800">GestCom App</h1>
    </header>
    <div class="container mx-auto p-6">
        <main>
            @yield(\'content\')
        </main>
    </div>
    <footer class="text-center text-sm text-gray-500 py-4 mt-6">
        &copy; {{ date(\'Y\') }} GestCom. Tous droits réservés.
    </footer>
</body>
</html>'
) ?></code></pre><button class="copy-btn">Copier</button></div>
            <p class="text-gray-700 mt-4"><strong>Décryptage :</strong> <code>@yield('content')</code> et <code>@yield('title', '...')</code> sont des "trous" que les vues enfants devront remplir. Le second argument de <code>@yield</code> est une valeur par défaut.</p>

            <p class="font-semibold text-gray-700 mt-4">Étape 2 : Mettre à jour la vue de la liste des produits</p>
            <p class="text-gray-700 mb-4">Modifions <code>resources/views/products/index.blade.php</code> pour qu'il hérite de ce layout.</p>
            <div class="code-block-wrapper"><pre class="code-block"><code class="language-html"><?= htmlspecialchars(
'@extends(\'layouts.app\')

@section(\'title\', \'Liste des Produits\')

@section(\'content\')
    <h1 class="text-3xl font-bold mb-6">Nos Produits</h1>
    <div class="bg-white p-6 rounded-lg shadow-md">
        <ul class="space-y-4">
            @forelse ($products as $product)
                <li class="border-b pb-2">
                    <a href="{{ route(\'products.show\', $product) }}" class="text-lg text-blue-600 hover:underline">
                        {{ $product->name }}
                    </a> 
                    <span class="text-gray-600">- {{ $product->formatted_price }}</span>
                </li>
            @empty
                <li class="text-gray-500">Aucun produit trouvé.</li>
            @endforelse
        </ul>
    </div>
@endsection'
) ?></code></pre><button class="copy-btn">Copier</button></div>
             <p class="text-gray-700 mt-4">Le code est maintenant bien plus propre. Si vous rechargez la page <code>/products</code>, elle aura désormais un header et un footer !</p>
        </div>

        <div class="mt-8 p-6 bg-blue-50 border-l-4 border-blue-500">
            <h4 class="text-xl font-bold text-gray-800 mb-2">Exercice A : Adapter la page de détail d'un produit</h4>
            <p class="text-gray-700 mb-4">Votre mission est d'appliquer exactement la même transformation à la page de détail d'un produit (<code>resources/views/products/show.blade.php</code>) pour qu'elle utilise également notre layout <code>layouts.app</code>.</p>
            <button class="solution-toggle">Voir la solution</button>
            <div class="solution-content space-y-6">
                <p class="font-semibold text-gray-700 mt-4">Solution pour <code>resources/views/products/show.blade.php</code></p>
                <div class="code-block-wrapper"><pre class="code-block"><code class="language-html"><?= htmlspecialchars(
'@extends(\'layouts.app\')

@section(\'title\', $product->name)

@section(\'content\')
    <div class="bg-white p-6 rounded-lg shadow-md">
        <a href="{{ route(\'products.index\') }}" class="text-blue-600 hover:underline mb-4 inline-block">&larr; Retour à la liste</a>
        <h1 class="text-3xl font-bold mb-2">{{ $product->name }}</h1>
        <p class="text-xl text-gray-700 mb-4">{{ $product->formatted_price }}</p>
        <div class="prose max-w-none">
            {{ $product->description }}
        </div>
        {{-- ... autres détails ... --}}
    </div>
@endsection'
) ?></code></pre><button class="copy-btn">Copier</button></div>
            </div>
        </div>
    </div>

    <!-- =================================================================== -->
    <!-- PARTIE 7.B : LA COMPOSITION AVEC LES COMPOSANTS DE LAYOUT -->
    <!-- =================================================================== -->
    <div class="bg-white p-6 rounded-lg shadow-sm border space-y-8 mt-12">
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">Approche 2 : La Composition avec les Composants <code>&lt;x-layout&gt;</code></h4>
            <p class="text-gray-700 mb-4">C'est l'approche moderne, favorisée par les nouveaux projets Laravel. Elle est basée sur la composition, ce qui la rend plus flexible et modulaire.</p>
            <p class="text-gray-700 mb-4"><strong>Analogie :</strong> Pensez à un assemblage de briques LEGO®. Le layout est une grosse brique de base avec des emplacements (`slots`). Vous construisez votre page en y emboîtant d'autres briques (le contenu, un header, une sidebar...). Vous n'héritez de rien, vous composez votre page. C'est plus flexible car vous pouvez facilement changer de "brique de base" (par exemple, avoir un layout pour les invités et un pour les administrateurs).</p>
        </div>

        <div>
            <h5 class="font-semibold text-gray-800 mb-2 mt-6">Atelier Guidé B : Construire un Layout Composé</h4>
            <p class="font-semibold text-gray-700">Étape 1 : Créer les composants du layout</p>
            <p class="text-gray-700 mb-4">Pour que Laravel les reconnaisse comme des composants, nous les plaçons dans <code>resources/views/components/</code>. Créez un sous-dossier <code>layouts</code> pour l'organisation.</p>
            <p class="text-gray-700 mb-2">Créez <code>resources/views/components/layouts/sidebar.blade.php</code> :</p>
            <div class="code-block-wrapper"><pre class="code-block"><code class="language-html"><?= htmlspecialchars(
'<aside class="w-64 bg-white shadow-md">
    <div class="p-4 font-bold border-b">GestCom App</div>
    <nav class="p-4 space-y-2">
        <a href="{{ route(\'products.index\') }}" class="block px-4 py-2 text-gray-700 rounded hover:bg-gray-200">Produits</a>
        {{-- Plus de liens ici --}}
    </nav>
</aside>'
) ?></code></pre><button class="copy-btn">Copier</button></div>

            <p class="font-semibold text-gray-700 mt-4">Étape 2 : Créer le composant de layout principal</p>
            <p class="text-gray-700 mb-4">Créez <code>resources/views/components/layouts/app.blade.php</code>. Notez l'utilisation de <code>{{ $slot }}</code> au lieu de <code>@yield</code>.</p>
            <div class="code-block-wrapper"><pre class="code-block"><code class="language-html"><?= htmlspecialchars(
'<!DOCTYPE html>
<html lang="{{ str_replace(\'_\', \'-\', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? \'Application Commerciale\' }}</title>
    @vite([\'resources/css/app.css\', \'resources/js/app.js\'])
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <x-layouts.sidebar />
        <div class="flex-1 flex flex-col overflow-hidden">
            @if(isset($header))
                <header class="bg-white shadow p-4">
                    <h1 class="text-xl font-bold">{{ $header }}</h1>
                </header>
            @endif
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-200 p-6">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>'
) ?></code></pre><button class="copy-btn">Copier</button></div>

            <p class="font-semibold text-gray-700 mt-4">Étape 3 : Créer une nouvelle page de tableau de bord avec ce layout</p>
            <p class="text-gray-700 mb-2">Ajoutez une route simple dans <code>routes/web.php</code> : <code>Route::get('/', fn() => view('dashboard'))->name('dashboard');</code></p>
            <p class="text-gray-700 mt-4 mb-2">Créez la vue <code>resources/views/dashboard.blade.php</code>. Observez la nouvelle syntaxe :</p>
            <div class="code-block-wrapper"><pre class="code-block"><code class="language-html"><?= htmlspecialchars(
'<x-layouts.app>
    <x-slot:title>
        Tableau de Bord
    </x-slot:title>

    <x-slot:header>
        Tableau de Bord
    </x-slot:header>

    <!-- Le contenu principal va ici, dans le slot par défaut -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-lg font-semibold">Statistique 1</h2>
            <p class="text-3xl font-bold mt-2">1,234</p>
        </div>
        <!-- ... autres cartes ... -->
    </div>
</x-layouts.app>'
) ?></code></pre><button class="copy-btn">Copier</button></div>
             <p class="text-gray-700 mt-4">Visitez la racine de votre site (<code>/</code>). Vous verrez votre nouveau tableau de bord, construit de manière 100% composable !</p>
        </div>

        <div class="mt-8 p-6 bg-blue-50 border-l-4 border-blue-500">
            <h4 class="text-xl font-bold text-gray-800 mb-2">Exercice B : Créer une page "Clients" avec le layout composable</h4>
            <p class="text-gray-700 mb-4">Votre mission est de créer une nouvelle page "Clients", accessible à l'URL <code>/clients</code>, en utilisant le composant de layout <code>x-layouts.app</code>.</p>
            <ol class="list-decimal ml-6 font-semibold text-gray-800 space-y-2">
                <li>Ajoutez une route pour <code>/clients</code> qui pointe vers une nouvelle vue <code>clients.index</code>.</li>
                <li>Créez la vue <code>resources/views/clients/index.blade.php</code>.</li>
                <li>Utilisez le composant <code>x-layouts.app</code> comme squelette.</li>
                <li>Passez un titre de page et un titre de header via les slots.</li>
                <li>Ajoutez un contenu simple dans le slot principal.</li>
            </ol>
            <button class="solution-toggle">Voir la solution</button>
            <div class="solution-content space-y-6">
                <p class="font-semibold text-gray-700 mt-4">1. Route dans <code>routes/web.php</code></p>
                <div class="code-block-wrapper"><pre class="code-block"><code class="language-php">Route::get('/clients', fn() => view('clients.index'))->name('clients.index');</code></pre><button class="copy-btn">Copier</button></div>
                <p class="font-semibold text-gray-700 mt-4">2. Contenu de <code>resources/views/clients/index.blade.php</code></p>
                <div class="code-block-wrapper"><pre class="code-block"><code class="language-html"><?= htmlspecialchars(
'<x-layouts.app>
    <x-slot:title>Liste des Clients</x-slot:title>
    <x-slot:header>Gestion des Clients</x-slot:header>

    <div class="bg-white p-6 rounded-lg shadow-md">
        <p>La liste des clients sera affichée ici.</p>
    </div>
</x-layouts.app>'
) ?></code></pre><button class="copy-btn">Copier</button></div>
            </div>
        </div>
    </div>
    
    <!-- =================================================================== -->
    <!-- PARTIE 7.C : ATELIER DE SYNTHÈSE -->
    <!-- =================================================================== -->
    <div class="bg-white p-6 rounded-lg shadow-sm border space-y-8 mt-12">
        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-2">Atelier de Synthèse : Une Modale Interactive dans un Layout Composé</h4>
            <p class="text-gray-700 mb-4">Nous allons maintenant assembler tous ces concepts pour créer une page de "Paramètres" où un bouton ouvrira une modale de confirmation interactive, le tout dans notre architecture par composants.</p>
            
            <p class="font-semibold text-gray-700">Étape 1 : Rendre le composant Modal interactif</p>
            <p class="text-gray-700 mb-4">Nous utiliserons Alpine.js pour l'interactivité. Assurez-vous de l'avoir installé (<code>npm install alpinejs</code>) et importé dans <code>resources/js/app.js</code> (<code>import Alpine from 'alpinejs'; window.Alpine = Alpine; Alpine.start();</code>).</p>
            <p class="text-gray-700 mb-2">Modifiez <code>resources/views/components/modal.blade.php</code> :</p>
            <div class="code-block-wrapper"><pre class="code-block"><code class="language-html"><?= htmlspecialchars(
'@props([\'name\'])

<div x-data="{ show: false, name: \'{{ $name }}\' }"
     x-show="show"
     x-on:open-modal.window="show = ($event.detail.name === name)"
     x-on:close-modal.window="show = false"
     x-on:keydown.escape.window="show = false"
     style="display: none;"
     class="fixed z-50 inset-0 flex items-center justify-center p-4">
    
    <div x-show="show" x-transition.opacity class="fixed inset-0 bg-gray-800 bg-opacity-75"></div>
    <div x-show="show" x-transition class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
        <div class="p-6">
            <h3 class="text-lg font-medium text-gray-900">{{ $title }}</h3>
            <div class="mt-2 text-sm text-gray-600">{{ $slot }}</div>
        </div>
        @if(isset($footer))
            <div class="bg-gray-50 px-6 py-4 flex justify-end space-x-3">{{ $footer }}</div>
        @endif
    </div>
</div>'
) ?></code></pre><button class="copy-btn">Copier</button></div>
            
            <p class="font-semibold text-gray-700 mt-4">Étape 2 : Créer la page "Paramètres" et le bouton de déclenchement</p>
            <p class="text-gray-700 mb-2">Ajoutez la route : <code>Route::get('/settings', fn() => view('settings.index'))->name('settings.index');</code></p>
            <p class="text-gray-700 mt-4 mb-2">Ajoutez un lien vers cette page dans votre sidebar (<code>components/layouts/sidebar.blade.php</code>).</p>
            <p class="text-gray-700 mt-4 mb-2">Créez la vue <code>resources/views/settings/index.blade.php</code> :</p>
            <div class="code-block-wrapper"><pre class="code-block"><code class="language-html"><?= htmlspecialchars(
'<x-layouts.app>
    <x-slot:title>Paramètres</x-slot:title>
    <x-slot:header>Paramètres de l\'Application</x-slot:header>

    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold mb-4">Actions Dangereuses</h2>
        <button x-data @click="$dispatch(\'open-modal\', { name: \'confirm-reset\' })"
                class="px-5 py-2 bg-red-600 text-white font-semibold rounded-lg shadow-md hover:bg-red-700">
            Réinitialiser les Données
        </button>
    </div>

    <x-modal name="confirm-reset">
        <x-slot:title>Confirmer la réinitialisation</x-slot:title>
        
        Êtes-vous absolument sûr de vouloir réinitialiser toutes les données ? Cette action est irréversible.

        <x-slot:footer>
            <button @click="$dispatch(\'close-modal\')" class="px-4 py-2 bg-gray-200 rounded-md hover:bg-gray-300">Annuler</button>
            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 ml-2">Oui, Réinitialiser</button>
        </x-slot:footer>
    </x-modal>
</x-layouts.app>'
) ?></code></pre><button class="copy-btn">Copier</button></div>
             <p class="text-gray-700 mt-4"><strong>Résultat :</strong> Vous avez maintenant une application avec une structure de layout moderne et composable, et une page de paramètres fonctionnelle où un bouton peut déclencher une modale de confirmation interactive. Vous maîtrisez les deux approches de l'architecture des vues dans Laravel.</p>
        </div>
    </div>
    <div class="text-right mt-8"> <a href="#page-top" class="text-sm font-semibold text-blue-600 hover:underline">↑ Retour en haut</a> </div>
</section>