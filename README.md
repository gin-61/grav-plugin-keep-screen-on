# Keep Screen On Plugin

** Needs more tests. For more detail look at To Do section at bottom of this page. **

The **Keep Screen On** Plugin is an extension for [Grav CMS](https://github.com/getgrav/grav). This plugin is to keep screen on for users who may be busy while doing things they read on page or for some other reason like cooking and want not to leave page.

- [Secure context: This feature is available only in secure contexts (HTTPS), in some or all supporting browsers.](https://developer.mozilla.org/en-US/docs/Web/API/Screen_Wake_Lock_API)


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
First thing to do is adding button to pages that we want it to be shown. That can be done easy by using the first field on plugin's settings which created to configure where to add button based on page's adress. For more information, that setting can be seen. After that, button will be seen on choosen pages with default settings, nothing more is needed to make it work.


## Credits

I like Grav CMS. I am thankful to everyone who worked on it and helped me on Discord and Forum. This is my first plugin for grav to show that. I hope it will be useful.

- Special thanks to [pamtbaau](https://github.com/pamtbaau) for their assistance giving code review.


## To Do

- [x] Test at Linux OS
- [ ] Test at Windows OS
- [ ] Test at Mac OS
- [x] Test at Android
- [x] Test at Iphone
- [ ] Make php code better
