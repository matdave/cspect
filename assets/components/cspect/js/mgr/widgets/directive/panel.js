cspect.panel.Directive = function(config) {
    config = config || {};
    Ext.apply(config, {
        id: "cspect-panel-directive",
        cls: "container form-with-labels",
        border: true,
        baseCls: 'modx-formpanel',
        url: MODx.config.connector_url,
        baseParams: {
            action: 'CSPect\\Processors\\Directives\\Update',
        },
        useLoadingMask: true,
        defaults: {
            layout: "form",
            labelAlign: "top",
            labelSeparator: "",
            anchor: "100%",
            border: false,
        },
        items: [
            MODx.util.getHeaderBreadCrumbs({
                html: cspect.directive.name + ' (' + cspect.directive.id + ')',
                xtype: "modx-header"
            }, [
                {
                    text: _('cspect.manage.page_title'),
                    href: '?a=manage&namespace=cspect',
                },
                {
                    text: _('cspect.manage.directive'),
                    href: null,
                }
            ]),
            {
                name: "id",
                xtype: "hidden"
            },
            {
                name: "name",
                xtype: "hidden"
            },
            {
                layout: "form",
                bodyCssClass: "main-wrapper",
                style: {
                    marginTop: "20px",
                },
                items: [
                    {
                        html: _('cspect.directive_desc.' + cspect.directive.name),
                    }
                ]
            }

        ],
        listeners: {
            setup: {
                fn: this.setup,
                scope: this,
            },
            success: {
                fn: this.success,
                scope: this,
            }
        }
    });
    cspect.panel.Directive.superclass.constructor.call(this, config);
}

Ext.extend(cspect.panel.Directive, MODx.FormPanel, {
    setup: function() {
        this.getForm().setValues(cspect.directive);
        this.fireEvent("ready");
        MODx.fireEvent("ready");
    },
    success: function(r) {
        if (r.result.object) {
            cspect.directive = r.result.object;
        }
    }
});

Ext.reg('cspect-panel-directive', cspect.panel.Directive);