cspect.panel.Source = function (config) {
    config = config || {
        source: {
            id: 0,
            name: '',
        }
    };
    Ext.applyIf(config, {
        formpanel: 'cspect-panel-source',
        cls: "container form-with-labels",
        border: true,
        baseCls: 'modx-formpanel',
        url: MODx.config.connector_url,
        baseParams: {
            action: 'CSPect\\Processors\\Sources\\Update',
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
                html: cspect.source.name + ' (' + cspect.source.id + ')',
                xtype: "modx-header"
            }, [
                {
                    text: _('cspect.manage.page_title'),
                    href: '?a=manage&namespace=cspect',
                },
                {
                    text: _('cspect.manage.source'),
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
            }, {
                layout: "form",
                bodyCssClass: "main-wrapper",
                style: {
                    marginTop: "20px",
                },
                items: [
                    {
                        xtype: "cspect-grid-sourcedirective",
                        source: cspect.source,
                    }
                ]
            }, {
                layout: "form",
                bodyCssClass: "main-wrapper",
                style: {
                    marginTop: "20px",
                },
                items: [
                    {
                        xtype: "cspect-grid-sourcecontext",
                        source: cspect.source,
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
    cspect.panel.Source.superclass.constructor.call(this, config);
}

Ext.extend(cspect.panel.Source, MODx.FormPanel, {
    setup: function () {
        this.getForm().setValues(cspect.source);
    },
    success: function (r) {
        if (r.result.object) {
            cspect.source = r.result.object;
        }
    }
});

Ext.reg('cspect-panel-source', cspect.panel.Source);