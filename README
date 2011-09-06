# SmartContext integration Plug-in

The `sfSmartContextPlugin` offers the integrate with [SmartContext](http://www.smartcontext.pl/).

## Instalation

  * Install the plugin:

        $ symfony plugin:install sfSmartContextPlugin

  * Add the sfSmartContextFilter to your filter chain:

        rendering: ~
        security:  ~

        # insert your own filters here
        smart_context:
          class: sfSmartContextFilter

        cache:     ~
        common:    ~
        execution: ~

## Configuration

  * Global configuration

    Global configuration is done in your application's app.yml file:

        all:
          smart_context_plugin:
            site:    http__yoursite.com
            enabled: true

  * Configuration per module

    To disable SmartContext in action **index** in module **default** add to your  ``apps/frontend/modules/default/config/module.yml`` file following configuration:

        all:
          index:
            smart_context:
              enabled: false
