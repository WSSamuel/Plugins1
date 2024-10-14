=== GothAmazon ===

Contributors: kapsulecorp
Tags: amazon affiliate, affiliate, affiliation, amazon, ecommerce, amazon product api

Stable tag: 3.2.8

Tested up to: 6.6
Requires at least: 6.0
Requires PHP: 7.4.0

License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

== Upgrade Notice ==

Optimisez votre Affiliation Amazon comme jamais avec l'un des plugins les plus complets existants ! Développé de A à Z par un SEO qui connait les vraies besoins de ce type de projets. / Optimize your Amazon Affiliation like never before with one of the most complete plugins available! Developed from A to Z by an SEO who knows the real needs of this type of project.

== Description ==

Optimisez votre Affiliation Amazon comme jamais avec l'un des plugins les plus complets existants ! Développé de A à Z par un SEO qui connait les vraies besoins de ce type de projets. Optimize your Amazon Affiliation like never before with one of the most complete plugins available! Developed from A to Z by an SEO who knows the real needs of this type of project.

- Module de listing d'items (sélectionné par keyword)
- Module d'affichage d'un block item par ASIN
- Module d'affichage d' block un item par keyword
- Module de création d'un e-commerce-like rapide
- Module pour créer des liens in-text d'affiliation intelligent (par recherche par kw ou par ASIN puis par kw quand indisponible)

- Cloaking / Obfuscation JS des liens
- Cloaking de l'url des images Amazon via REST API
- Cache intelligent de 24H.
- Options intelligentes pour rediriger votre traffic en cas d'article indisponible
- Widgets intelligents qui peuvent afficher des produits différents selon les pages de votre site
- Intégration enfantine par shortcode.
- Module permettant d'optimiser votre quota Amazon

- 100% Responsive
- Design moderne et épuré
- Interface ergonomique, pas de chichi, hyper light, pour ceux qui veulent faire du cash et pas de la contemplation d'interface !

- 100% Compatible Amazon Product Advertising API 5.0

Attention, vous devrez bien évidemment utiliser votre clé d'API affilié Amazon, à demander directement sur l'espace affiliation Amazon

== Installation ==

1. Téléchargez les fichiers de l'extension dans le répertoire `/wp-content/plugins/plugin-name`, ou installez directement le plugin via l'écran des plugins WordPress.
2. Activez le plugin via l'écran "Extensions" de WordPress
3. Cliquez sur GothamAzon (Paramètres) dans le menu de gauche pour configurer les options générales du plugin

.::: README IN ENGLISH :::.

1. Upload the plugin files to the `/wp-content/plugins/plugin-name` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Click to GothamAzon (Settings) on the left menu to configure general options.

== Frequently Asked Questions ==

= Y-a-il des widgets ? =

Oui, vous pouvez générer vos modules par widgets en 2 clics !

= Quels sont les shortcodes ? =

Un générateur de shortcode est fourni avec l'éditeur de texte Classic Editor (en mode visuel) pour insérer vos shortcodes en un clic. Mais si vous utilisez Gutemberg voici les shortcodes :

::. Créé une mini boutique basée sur une recherche par mot clé .::
[boutique title="" nono="1" prixmin="1" prixmax="1000000" cat="All" smartitem4mobile="defaut" boodisplayprice="defaut"/]

- title = Saisissez le mot clé de votre choix Ou plusieurs mots clés séparés par | : ex : smartphone | tv => Affichera aléatoirement des smartphones soit des TV
- prixmin = Fixez un prix MIN (en centime) ex : 10€ => "1000". Laissez vide pour ne pas fixer de minimum
- prixmax = Fixez un prix MAX (en centime) ex : 10€ => "1000". Laissez vide pour ne pas fixer de minimum
- nono = Nombre d'items affichés (3 par défaut)
- cat = Choisis une catégorie Amazon dans laquelle effectuer la recherche (Liste sur https://webservices.amazon.com/paapi5/documentation/locale-reference/france.html). Laissez vide pour ne pas filtrer la recherche.
- legal = oui/non | Affichez ou non les mentions légales. Laissez vide pour appliquer les paramètres généraux.
- design = full/sidebar | Design pour content ou pour sidebar. Laissez vide pour utiliser le design "content" par défaut.
- hidetitre = oui/non | Oui = Masquer le titre. Laissez vide pour appliquer les paramètres généraux.
- aturner = oui/non | Afficher le bouton (voir d'autres articles) . Laissez vide pour appliquer les paramètres généraux.
- boodisplayprice = oui/non/defaut | Affichez ou non le prix de l'article
- sort = critère de recherche de l'item (pertinence, prix, avis utilisateurs, nouveauté...)
- vendeur = Amazon uniquement ou Amazon + Marketplace
- economiemin = % de réduction minimum exigé
- marque = Saisissez la marque fabricante de l'objet, ex: "Nintendo"
- smartitem4mobile = Affiche un nombre différent d'items sur mobile (toujours inférieur au nombre fixé dans nono). Utilité : Si vous décidez d'afficher 8 items sur PC, cela risque d'être trop sur mobile. Fixez alors ici le nombre à 4 par exemple. Par ailleurs, si votre design sur PC affiche 3 colonnes d'items et votre design mobile 2 colonnes. Cela permet de ne pas laisser une ligne impaire. Sans cette fonction : Ligne 1 sur mobile : 2 items - Ligne 2 sur mobile : 1 item VS Avec cette fonction :  Ligne 1 sur mobile : 2 items - Pas de ligne 2. Si vous laissez vide , le plugin détectera si le nombre fixé par nono est impaire. Si c'est le cas, il retranchera une unité automatiquement.


::. Créé un lien texte Amazon par ASIN .::

[inlineASIN asin="B00DQ8ND0M" ancre="Cliquez Ici" inlineprice="non" inlinekw="batman & robin" prixmin="1" cat="All" image_anchor_url="" classcsscta=""]

- asin = ID du produit
- ancre = Saisissez l'ancre du lien (servira de balise alt s'il s'agit d'une image)
- image_anchor_url = saisissez l'url de l'image qui servira d'ancre au lien (optionnel)
- inlineprice = oui/non | ajoute à l'ancre la mention "(à partir de xx € automatiquement)". Attention, l'activation de cette option empêche l'activation de l'option "appel à l'API Amazon au clic uniquement" permettant d'économiser votre Quota Amazon.
- classcsscta = gamz_cta(cta du plugin)/votre classe css/vide | ajoute une classe css au lien intelligent, ce qui lui permet de remplacer ou de se fondre parmis vos CTA déjà existants. 
- inlinekw = Saisissez le mot clé parachute de votre choix. Sera utilisé si le produit désigné par l'ASIN est indisponible.
- prixmin = Fixez un prix MIN parachute (en centime) ex : 10€ => "1000". Laissez vide pour ne pas fixer de minimum
- cat = Choisis une catégorie Amazon parachute dans laquelle effectuer la recherche (Liste sur https://webservices.amazon.com/paapi5/documentation/locale-reference/france.html). Laissez vide pour ne pas filtrer la recherche.


::. Créé un lien texte Amazon dynamique intelligent .::
[inlinemonetizer inlinekw="keyword" ancre="Cliquez Ici" inlineprice="non" prixmin="1" cat="All" image_anchor_url="" classcsscta=""/]

- inlinekw = Saisissez le mot clé de votre choix Ou plusieurs mots clés séparés par | : ex : smartphone | tv => Affichera aléatoirement des smartphones soit des TV
- ancre = Saisissez l'ancre du lien (servira de balise alt s'il s'agit d'une image)
- prixmin = Fixez un prix MIN (en centime) ex : 10€ => "1000". Laissez vide pour ne pas fixer de minimum
- cat = Choisis une catégorie Amazon dans laquelle effectuer la recherche (Liste sur https://webservices.amazon.com/paapi5/documentation/locale-reference/france.html). Laissez vide pour ne pas filtrer la recherche.
- inlineprice = oui/non | ajoute à l'ancre la mention "(à partir de xx € automatiquement)". Attention, l'activation de cette option empêche l'activation de l'option "appel à l'API Amazon au clic uniquement" permettant d'économiser votre Quota Amazon.
- image_anchor_url = saisissez l'url de l'image qui servira d'ancre au lien (optionnel)
- sort = critère de recherche de l'item (pertinence, prix, avis utilisateurs, nouveauté...)
- vendeur = Amazon uniquement ou Amazon + Marketplace
- marque = Saisissez la marque fabricante de l'objet, ex: "Nintendo"
- classcsscta = gamz_cta(cta du plugin)/votre classe css/vide | ajoute une classe css au lien intelligent, ce qui lui permet de remplacer ou de se fondre parmis vos CTA déjà existants. 

::. Créé une fiche produit basée sur une recherche par mot clé .::
[spotlightbyq title="" prixmin="1" cat="All" force1pic="" titremano="" descriptionmano="" boodisplayprice="defaut"/]

- title = Saisissez le mot clé de votre choix, Ou plusieurs mots clés séparés par | : ex : smartphone | tv => Affichera aléatoirement des smartphones soit des TV
- prixmin = Fixez un prix MIN (en centime) ex : 10€ => "1000". Laissez vide pour ne pas fixer de minimum
- prixmax = Fixez un prix MAX (en centime) ex : 10€ => "1000". Laissez vide pour ne pas fixer de minimum
- force1pic = oui/non/vide | Forcez l'affichage d'une seule image, au lieu de 4 (si disponible)
- cat = Choisis une catégorie Amazon dans laquelle effectuer la recherche (Liste sur https://webservices.amazon.com/paapi5/documentation/locale-reference/france.html). Laissez  vide pour ne pas filtrer la recherche.
- titremano = Renseignez votre titre personnalisé ou laissez vide pour utiliser le titre Amazon
- descriptionmano = Renseignez votre description personnalisé ou laissez vide pour utiliser la description Amazon (spinnée)
- boodisplayprice = oui/non/defaut | Affichez ou non le prix de l'article
- design = full/sidebar | Design pour content ou pour sidebar. Laissez vide pour utiliser le design "content" par défaut.
- sort = critère de recherche de l'item (pertinence, prix, avis utilisateurs, nouveauté...)
- vendeur = Amazon uniquement ou Amazon + Marketplace
- marque = Saisissez la marque fabricante de l'objet, ex: "Nintendo"
- economiemin = % de réduction minimum exigé
- legal = oui/non/vide | Affichez ou non les mentions légales. Laissez vide pour appliquer les paramètres généraux.

::. Créé une fiche produit basée sur l'ASIN .::
[gothasin asin="" titremano="" descriptionmano="" force1pic="" parachutekw="" boodisplayprice="defaut"/]

- asin = Renseignez l'ASIN Amazon de l'item de votre choix
- titremano = Renseignez votre titre personnalisé ou laissez vide pour utiliser le titre Amazon
- descriptionmano = Renseignez votre description personnalisé ou laissez vide pour utiliser la description Amazon (spinnée)
- force1pic = oui/non/vide | Forcez l'affichage d'une seule image, au lieu de 4 (si disponible)
- parachutekw = saisissez un mot clé définissant le produit que vous mettez en avant. Si l'ASIN est devenu indisponible, cela sera remplacé par un produit équivalent
- boodisplayprice = oui/non/defaut | Affichez ou non le prix de l'article. Defaut pour appliquer les paramètres généraux.
- design = full/sidebar | Design pour content ou pour sidebar. Laissez vide pour utiliser le design "content" par défaut.
- legal = oui/non/vide | Affichez ou non les mentions légales. Laissez vide pour appliquer les paramètres généraux.
- prixmin = Fixez un prix MIN parachute (en centime) ex : 10€ => "1000". Laissez vide pour ne pas fixer de minimum
- cat = Choisis une catégorie Amazon parachute dans laquelle effectuer la recherche (Liste sur https://webservices.amazon.com/paapi5/documentation/locale-reference/france.html). Laissez vide pour ne pas filtrer la recherche.

::. Créé un index des pages de votre boutique .::
[speedyshop cat=""/] // renseignez l'ID de la catégorie où sont postés les articles contenant une page boutique

::. Créé un module "catégorie en relation" via les pages de votre boutique .::
[related_speedyshop cat="" nono="1"/] // renseignez l'ID de la catégorie où sont postés les articles contenant une page boutique


== Screenshots ==

1. This screen shot description corresponds to screenshot-1.png. Note that the screenshot is taken from the directory that contains the stable readme.txt.

> This screenshot show the admin interface

2. This screen shot description corresponds to screenshot-2.png. Note that the screenshot is taken from the directory that contains the stable readme.txt.

> This screenshot show 1/3 widget

3. This screen shot description corresponds to screenshot-3.png. Note that the screenshot is taken from the directory that contains the stable readme.txt.

> This screenshot show the shortcode module into the Classic Wordpress Editor

4. This screen shot description corresponds to screenshot-4.png. Note that the screenshot is taken from the directory that contains the stable readme.txt.

> This screenshot show the shortcode module into the Classic Wordpress Editor

5. This screen shot description corresponds to screenshot-5.png. Note that the screenshot is taken from the directory that contains the stable readme.txt.

> This screenshot show a smart generated shopping page (in 10 seconds)

6. This screen shot description corresponds to screenshot-6.png. Note that the screenshot is taken from the directory that contains the stable readme.txt.

> This screenshot show a smart generated product encart (in 10 seconds)

== Changelog ==

= 3.2.8 = 

- Fix price bug

= 3.2.7 = 

- Fix bug parachute inline asin
- Fix bug with wegoboard pics

= 3.2.6 = 

- Fix display bugs

= 3.2.5 = 

- Fix display bugs

= 3.2.4 = 

- Fix bugs

= 3.2.3 = 

- Fix bugs

= 3.2.2 = 

- Add new mentions on Amazon items

= 3.2.1 = 

- Open all links in target blank 

= 3.2.0 = 

- Fix critical bug in php 8.3
- Add sliderpics on carroussel mode

= 3.1.8 = 

- Add legal mentions 

= 3.1.7 = 

- Add legal mentions 

= 3.1.6 = 

- Fix bug 

= 3.1.5 = 

- Fix bug 

= 3.1.4 = 

- Fix bug 

= 3.1.3 = 

- Fix bug with pictures

= 3.1.2 = 

- New icons
- Fix bug with pictures

= 3.1.1 = 

- New icons

= 3.1 = 

- Add Carrousel Design
- Prepare Mega Fusion Mode

= 3.0.5 = 

- Fix minor bugs

= 3.0.4 = 
- Fix category bug in log
- Add Ama Icon on Textlink
- Ready for Wordpress 6

= 3.0.3 = 
- Fix inline text bug to log
- Add new merchant

= 3.0.2 = 
- Fix inline text bug to log

= 3.0.1 = 
- Fix multiples bugs

= 3.0.0 = 
- Multi Feed API is now available

= 2.6.0 = 
- Multi Feed API Ready

= 2.5.3 = 
- Fix Bug with cache conflict

= 2.5.2 = 
- Fix Minor Bugs
- Wordpress 5.9.3 Ready

= 2.5.1 = 
- Fix JS Obf

= 2.5.0 = 
- Prepare Plugin to accept others products feeds

= 2.4.9 = 
- Optimize smart js

= 2.4.8 = 
- Fix bug with linquery

= 2.4.7 = 
- Optimize smart js
- Add Amazon Label

= 2.4.6 = 
- Fix price bug
- Fix CSS bug

= 2.4.5 = 
- Add gestion of nopics

= 2.4.4 = 
- Fix minor bugs when logs empty

= 2.4.3 = 
- Add new options

= 2.4.2 = 
- Fix bug in widget

= 2.4.1 = 
- Optimize archive

= 2.4.0 = 
- Switch Server Call

= 2.3.9 = 
- Fix minors bugs

= 2.3.8 = 
- Fix minors bugs

= 2.3.7 = 
- Fix minors bugs

= 2.3.6 =
- Force API in specific widgets 
- Fix minors bugs

= 2.3.5 =
- Add Merchant and system when Amazon API call fail

= 2.3.4 =
- Fix bug on image hover
- Add Merchant

= 2.3.3 =
- Use Glob to find similar feed in Tokyo4 Mode

= 2.3.2 =
- Fix CTA Bug

= 2.3.1 =
- Change Folder of Temp File

= 2.3.0 =
- Launch Tokyo4 Mode

= 2.2.3 =
- Fix bug when 2 smart parachute was called in the same page

= 2.2.2 =
- Smart Parachute Backlink with Keyword
- Add Amazon Icon on products blocks

= 2.2.1 =
- Show a message, in front, when Amazon API call fail (only for GTZ Store and not in widget)

= 2.2.0 =
- Renforce Amazon Partner terms and conditions

= 2.1.9 =
- Fix bug when Check Licence is down

= 2.1.8 =
- New message in footer to comply with the Amazon Partner terms and conditions (AMP Fix)

= 2.1.7 =
- New message in footer to comply with the Amazon Partner terms and conditions 

= 2.1.6 =
- improve the API token to limit connections

= 2.1.5 =
- Find a workaround when wp_remote_get is blocked by the web host

= 2.1.3 =
- Fix bug in PHP8

= 2.1.3 =
- Conditional call the cloaking function to improve compatibility with all our plugins

= 2.1.2 =
- Fix Bug about : View More Button
- Optimize CSS

= 2.1.1 =
- Fix Bug about currency in sidebar

= 2.1.0 =
- Fix CSS Bug when rating is disabled
- Fix CSS Notice Error
- Add Random Multiple Random Query
- Add Random Amazon Tracking Tag
- Optimize Arborescence

= 2.0.8 =
- Optimize CSS and JS

= 2.0.7 =
- Change ABSPATH 

= 2.0.6 =
- Fix CSS Bug with SVG
- Change Widget Class Name in order to prevent conflict with other plugin

= 2.0.5 =
- Improve Smart CSS for CTA Background

= 2.0.4 =
- Add Smart CSS for CTA Background

= 2.0.3 =
- Fix a bug that appears on first launch

= 2.0.2 =
- Fix Bug when custom color are not set (for previous installation)

= 2.0.1 =
- Fix bug which reset settings when WP REST API is down
- Sanitize CSS
- Customize main color in admin with color picker

= 2.0.0 =
- Improve Build Shop

= 1.9.9 =
- Fix bug about image size on inlinetxt module anchor

= 1.9.8 =
- Fix bug about image size on inlinetxt module anchor

= 1.9.7 =
- Fix bug

= 1.9.6 =
- Fix bug

= 1.9.5 =
- Fix bug about price min on parachute GothamSpotlightbyAsin

= 1.9.4 =
- Fix bug

= 1.9.3 =
- Add Setting for Caching Time
- Addition of the "hide title" function in tinymce

= 1.9.2 =
- Fix Bugs when in SpotlightQ when ASIN is Down

= 1.9.1 =
- Fix Bugs

= 1.9.0 =
- Fix Bugs
- AMP Ready

= 1.8.3 =
- Fix Minor Bugs

= 1.8.2 =
- Fix Bug about Check Licence API (CUrl Error)
- Fix Bug unexpected output characters at launch
- Fix Minor Bugs

= 1.8.1 =
- Fix Bug about Search by Brand

= 1.8.0 =
- Add Filter Search by Brand

= 1.7.0 =
- Add Price Max on Spotlight

= 1.6.4 =
- Fix CSS bug on Reduc Price

= 1.6.3 =
- Better Presentation at First launch

= 1.6.2 =
- Fix Bug Encryption

= 1.6.1 =
- Fix Bug SmartItem4 Mobile = 1

= 1.6.0 =
- Compatibility with Wordpress 5.5
- Fix Upload Image Bug

= 1.5.0 =
- Caching REST APi for cloaking pics

= 1.4.2 =
- Fix Bug

= 1.4.1 =
- Fix Bug Pattern Regex Cloaking Pix (Gestion du _)
- Add NeufUnik option in shortcode Boutique

= 1.4.0 =
- Encrypt Amazon Key
- Optimize Plugin

= 1.3.6 =
- Seller's choose in general settings

= 1.3.5 =
- Addition of Seller : Amazon / All

= 1.3.0 =
- Fix Bug of Sort Search Item
- Addition of MinSavingPercent

= 1.2.0 =
- Addition of the indication of the minimum price and the category in the parachute of Gotham Spotlight ASIN 

= 1.1.4 =
- Fix Bug ? character in temp file with Preg-Replace

= 1.1.3 =
- Fix Bug Pattern Regex Cloaking Pix (Gestion du -)

= 1.1.2 =
- Fix Bug Pattern Regex Cloaking Pix (Gestion du +)

= 1.1.1 =
- Gestion du multi inline sur la meme page + Eco API

= 1.0.5 =
- Change Temp Name File (Eco API)

= 1.0.4 =
- Change Temp Name File (Eco API)

= 1.0.3 =
- Fix bug

= 1.0.0 =
- Plugin launch

= 0.8 =
- Beta Testing