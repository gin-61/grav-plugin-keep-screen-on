# Keep Screen On Plugin


The **Keep Screen On** Plugin is an extension for [Grav CMS](https://github.com/getgrav/grav). This plugin is to keep screen on for users who may be busy while doing things they read on page or for some other reason like cooking and want not to leave page.

## Installation

Installing the Keep Screen On plugin can be done in one of three ways: The GPM (Grav Package Manager) installation method lets you quickly install the plugin with a simple terminal command, the manual method lets you do so via a zip file, and the admin method lets you do so via the Admin Plugin.

### GPM Installation (Preferred)

To install the plugin via the [GPM](https://learn.getgrav.org/cli-console/grav-cli-gpm), through your system's terminal (also called the command line), navigate to the root of your Grav-installation, and enter:

    bin/gpm install keep-screen-on

This will install the Keep Screen On plugin into your `/user/plugins`-directory within Grav. Its files can be found under `/your/site/grav/user/plugins/keep-screen-on`.

### Manual Installation

To install the plugin manually, download the zip-version of this repository and unzip it under `/your/site/grav/user/plugins`. Then rename the folder to `keep-screen-on`. You can find these files on [GitHub](https://github.com//grav-plugin-keep-screen-on) or via [GetGrav.org](https://getgrav.org/downloads/plugins).

You should now have all the plugin files under

    /your/site/grav/user/plugins/keep-screen-on
	
> NOTE: This plugin is a modular component for Grav which may require other plugins to operate, please see its [blueprints.yaml-file on GitHub](https://github.com//grav-plugin-keep-screen-on/blob/main/blueprints.yaml).

### Admin Plugin

If you use the Admin Plugin, you can install the plugin directly by browsing the `Plugins`-menu and clicking on the `Add` button.

## Configuration

Before configuring this plugin, you should copy the `user/plugins/keep-screen-on/keep-screen-on.yaml` to `user/config/plugins/keep-screen-on.yaml` and only edit that copy.

Here is the default configuration and an explanation of available options:

```yaml
enabled: true
```

Note that if you use the Admin Plugin, a file with your configuration named keep-screen-on.yaml will be saved in the `user/config/plugins/`-folder once the configuration is saved in the Admin.

## Usage

At plugin settings there are many fields that effect how button looks.
Those can be edited to change default settings of the button.

## Credits

I like Grav CMS. I am thankful to everyone who worked on it and helped me on Discord and Forum. This is my first plugin for grav to show that. I hope it will be useful.

## To Do

- [ ] Actually it does what it is created for but if there is a bug lets find it^^.

