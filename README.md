# Keep Screen On Plugin

** Needs more tests. For more detail look at To Do section at bottom of this page. **

The **Keep Screen On** Plugin is an extension for [Grav CMS](https://github.com/getgrav/grav). This plugin is to keep screen on for users who may be busy while doing things they read on page or for some other reason like cooking and want not to leave page.

## Installation

### Manual Installation

To install the plugin manually, download the zip-version of this repository and unzip it under `/your/site/grav/user/plugins`. Then rename the folder to `keep-screen-on`. You can find these files on [GitHub](https://github.com//grav-plugin-keep-screen-on) or via [GetGrav.org](https://getgrav.org/downloads/plugins).

You should now have all the plugin files under

    /your/site/grav/user/plugins/keep-screen-on
	

## Configuration

At Plugins section of Admin Plugin there is this plugin that has many fields that effect how button looks.
Those can be edited to change default settings of the button.


Note that if you use the Admin Plugin, a file with your configuration named keep-screen-on.yaml will be saved in the `user/config/plugins/`-folder once the configuration is saved in the Admin.

## Usage
[keep-screen-on] shortcode can be added to content section in pages on admin plugin or to md file to show the button which works for switching modes.


## Credits

I like Grav CMS. I am thankful to everyone who worked on it and helped me on Discord and Forum. This is my first plugin for grav to show that. I hope it will be useful.

## To Do

- [ ] Test at Windows OS
- [ ] Test at Iphone
- [ ] Test at Mac OS
- [ ] Make php code better
- [ ] Try twig shortcode
