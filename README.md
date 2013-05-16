WordPress Inferno.
===

Inferno is a premium theme enhancement library. It is extremely powerful but still easy to use. Inferno comes with seperate modules which You may activate and deactivate just as You need them. Deactivated modules won't be even loaded so You save performance (so the hole plugin is written as performant as possible).

Following modules are included:
- **Infernal Panel** a plain admin panel for WordPress that aims to be easy (and therefore usable for non-programmers after reading the documentation), beautiful, flexible and really powerful.
- Infernal Portfolio
- Infernal Flame
- Infernal FAQ
- Infernal Slider
- Infernal Society


Features
---

- Easy embed in theme folder or use it as a common plugin.
- Import and export .xml files with your settings. Or just leave a default settings.xml in your theme folder to use these settings automatically
- Secure data handling, using wp_nonce()
- Easy and fast option call in your theme. Once globalized, you can call any option by $infernal_option['your-option-name'], also all your Infernal Panel settings are stored in just one WordPress data row, so it creates absolutely no junk entries.
- Supports following types: text, textarea, select, radio, font, range, file, colorpicker.
- Finally you can add a help section in the panel itself. Content is fetched from a help.xml in the active theme directory.
- Does it need more? Tell us or leave it as simple and beautiful as it is :)


Infernal Flame.
---

Infernal Flame is a powerful, advanced and mostly complete widget and shortcode kit for Your WordPress blog.

Visit http://themedale.net/script/infernal-flame/2 for more details.

Widgets
---

- Recent tweets Widget
- Flickr images
- Video embed
- Social icons


Next on todo list
---

- conditional asset loading without modernizr
- update + minify all used scripts and stylesheets
- improve modernizr usage
- improve overall script performance + script minify
- add hover_effect to infernal icons (pulse + spin)
- Improve the button shortcode (make the color attribute accept all css compliant color values, add a css transition to the hover and active states, let it be flat and with gradient, add more default color values)
- update the Inferno header image
- add dribbble widget
- make Inferno multilingual

Ideas for future versions
---

- add image filter to aq_resize (hover_effect & image_effect)
- call admin scripts when needed only http://codex.wordpress.org/Plugin_API/Action_Reference/admin_enqueue_scripts
- handle different settings for different sliders. best way to handle this via an extern file? // probably an abomination of idea. i still let this stay here, but probably is never going to become true
- add template files in theme directory for portfolio output
- portfolio doesn't generate any effects. this will be the job of infernal flame. this way, fold and flip effects can be used not only for portfolio items but for everything (post, etc).
- not an idea, but is there a way to dynamically generate preview thumbs with custom width and height and fold, flip and default effect without having to determine the column width? via css only? also, the input px method got the problem that there is only one width specified, but what is about full-width pages and pages with sidebar?
- support videos in slider
- integrate markdown for the xml setting files // why was that?
- make the plugin read a default theme file which will set up other options than the infernal panel options to the needed one.
- new extension for customer reviews?
- make modules from config active / deactive for first use


Dependencies
---

- infernal portfolio will not work without infernal flame


Known bugs
---

- portfolio previews with fold effect in safari look wrong, 
- changing the tab in the infernal panel makes the panel content jump (probably some margin bug, but not that important for now)
- when activating or deactivating the plugin there is one reload needed to make the activated / deactivated infernal plugin appear / disappear from the admin navigation