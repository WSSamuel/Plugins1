=== Batsignal ===

Contributors: kapsulecorp
Tags: popup, popup light, popup on scroll, popup with timer, shortcode

Stable tag: 2.1.7
Tested up to: 6.6
Requires at least: 6.0
Requires PHP: 7.4.0

License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

== Upgrade Notice ==

Plugin ULTRA Léger permettant de lancer une popup depuis n'importe quelle page via un shortcode.
Ce plugin n'est pas une usine à gaz mais est réellement efficace.

Paramétrez : 
- L'url de l'image, sa taille, et sa balise ALT
- Le lien de destination et l'ouverture ou non dans un nouvel onglet
- Un cookie qui empechera la popup de s'afficher à nouveau avant X minutes
- Le déclencheur (timer ou au scroll)

ENG :

ULTRA Light plugin allowing to fire a popup from any page via a shortcode.
This plugin is not a gas factory but is really efficient.

Configure:

- The url of the image, its size, and its ALT tag
- The destination link and opening or not in a new tab
- A cookie that will prevent the popup from displaying again before X minutes
- The trigger (timer or on scroll)

== Description ==

ULTRA Light plugin allowing to fire a popup from any page via a shortcode.
This plugin is not a gas factory but is really efficient.

.: IN FRENCH :.

Plugin ULTRA Léger permettant de lancer une popup depuis n'importe quelle page via un shortcode.
Ce plugin n'est pas une usine à gaz mais est réellement efficace.


== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/plugin-name` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Click to LaunchMyBatsignal (Settings) on the left menu to configure the repetition of the popup, and the trigger (by default)
4. Insert the popup where you want with the following shortcode, either directly in your articles / pages, or directly in your theme (in footer.php for example)

[batsignal id='1' image_url='https://exemple.com/pics1.jpg' image_alt='My Pics' target_url='https://exemple.com/moneypage' target_b='blank' largeur='600' hauteur='400' trigger_unit='px' trigger='600' expires='3600']

( Required )
id = Popup ID
image_url = Url of pictures
image_alt = Title of your pictures
target_url = Target URL (Leave empty if necessary, the popup will then close when you click on the image.)
target_b = Open in new tab or not (Leave blank to open in self page)
largeur = Image width
hauteur = Image height

( Optional = Override General Parameters )
trigger_unit = 'px' (on scroll) / 'sec' (after x seconds)
trigger = Trigger value (x pixels / x seconds)
expires = Delay before popup is fire again (in seconds)

.::: EXPLICATIONS EN FRANCAIS :::.

1. Téléchargez les fichiers de l'extension dans le répertoire `/wp-content/plugins/plugin-name`, ou installez directement le plugin via l'écran des plugins WordPress.
2. Activez le plugin via l'écran "Extensions" de WordPress
3. Cliquez sur LaunchMyBatsignal (Paramètres) dans le menu de gauche pour configurer le déclencheur de la popup et la durée avant un nouvel affichage (par défaut)
4. Insérez la popup où vous voulez avec le shortcode suivant, soit directement dans vos articles/pages, soit directement dans votre theme (en footer.php par exemple)

[batsignal id='1' image_url='https://exemple.com/pics1.jpg' image_alt='My Pics' target_url='https://exemple.com/moneypage' target_b='blank' largeur='600' hauteur='400' trigger_unit='px' trigger='600' expires='3600']

( Obligatoire )
id = ID de la popup
image_url = Url de l'image
image_alt = Titre de l'image
target_url = Url vers laquel sera dirigé le visiteur au clic (Laissez vide si nécessaire, la popup se fermera alors au clic sur l'image.)
target_b = Ouverture dans un nouvel onglet ou non
largeur = Largeur de l'image
hauteur = Hauteur de la l'image

( En Option = Ecrase les paramètres généraux )
trigger_unit = 'px' (déclenchement au déroulement) / 'sec' (déclenchement après x secondes)
trigger = valeur du déclencheur (x pixels / x secondes)
expires = Délai avant que la popup soit à nouveau affichée (en secondes)


== Frequently Asked Questions ==

= This plugin is really light? =

YES lighter than that, it does not exist! 

= What are the shortcodes ? =

[batsignal id='1' image_url='https://exemple.com/pics1.jpg' image_alt='My Pics' target_url='https://exemple.com/moneypage' target_b='blank' largeur='600' hauteur='400' trigger_unit='px' trigger='600' expires='3600']

( Required )
id = Popup ID
image_url = Url of pictures
image_alt = Title of your pictures
target_url = Target URL
target_b = Open in new tab or not (Leave blank to open in self page)
largeur = Image width
hauteur = Image height

( Optional = Override General Parameters )
trigger_unit = 'px' (on scroll) / 'sec' (after x seconds)
trigger = Trigger value (x pixels / x seconds)
expires = Delay before popup is fire again (in seconds)


== Screenshots ==

1. This screen shot description corresponds to screenshot-1.png. Note that the screenshot is taken from the directory that contains the stable readme.txt.

> This screenshot show the popup

== Changelog ==

= 2.1.7 =

- Fix bug

= 2.1.6 =

- Push popup in footer

= 2.1.4 =

- Fix mispelling

= 2.1.3 =

- Fix minor bug with getimagesize in PHP 8

= 2.1.2 =

- Hide JS Comment in Source Code

= 2.1.1 =

- Fix minor bug with sanitize

= 2.1.0 =

- Fix bug when generales rules are empty
- Increase Z-Index in CSS
- Increase explications

= 2.0.2 =

- Fix bug CSS in Admin
- Add possibility to leave blank the target url

= 2.0.1 =

- Fix bug CSS 

= 2.0.0 =

- Multiples Popup
- Cache Support
- Bug Fix

= 1.2.3 =

- Fix iPad CSS Bug

= 1.2.2 =

- Fix CSS Bug

= 1.1.6 =

- Clarify Settings

= 1.1.5 =

- Fix English Translation

= 1.1.3 =
- Fix Minor Bug

= 1.1.1 =
- Add shortcode readme into the plugin

= 1.1 =
- Setting Pixel Scroll Launcher

= 1.0 =
- Plugin launch