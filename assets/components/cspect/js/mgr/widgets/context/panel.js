cspect.panel.Context = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        formpanel: 'cspect-panel-context' + config.key,
        cls: 'cspect-panel-context',
        baseCls: 'modx-formpanel',
        border: false,
        autoScroll: true,
        url: cspect.config.connectorUrl,
        baseParams: {
            action: 'CSPect\\Processors\\Contexts\\Update',
            context_key: config.key
        },
        defaults: {
            anchor: '100%',
        },
        buttons: [
            {
                text: _('save'),
                cls: 'primary-button',
                handler: this.submit,
                scope: this
            }
        ],
        items: [
            {
                html: '<h3>' + config.title + '</h3>'
            },
            {
                html: '<p>' + config.description + '</p>',
                cls: 'panel-desc',
                hidden: config.description === ''
            },
            {
                xtype: 'combo-boolean',
                fieldLabel: _('settings_cspect.report_only'),
                name: 'report_only',
            },
            {
                xtype: 'textfield',
                fieldLabel: _('settings_cspect.report_uri'),
                name: 'report_uri',
            },
            {
                xtype: 'textfield',
                fieldLabel: _('settings_cspect.report_to'),
                name: 'report_to',
            },
            {
                xtype: 'textarea',
                fieldLabel: _('settings_cspect.reporting_endpoints'),
                name: 'reporting_endpoints',
            }
        ],
        listeners: {
            'beforerender': function (panel) {
                this.getItems(panel);
            }
        }
    });
    cspect.panel.Context.superclass.constructor.call(this, config);
}
Ext.extend(cspect.panel.Context, MODx.FormPanel, {
    getItems: async function (panel) {
        var record = {
            report_only: MODx.config['cspect.report_only'],
            report_uri: MODx.config['cspect.report_uri'],
            report_to: MODx.config['cspect.report_to'],
            reporting_endpoints:  MODx.config['cspect.reporting_endpoints'],
        };
        if (panel.config.key !== 'mgr') {
            record = {
                report_only: _('cspect.context.inherited'),
                report_uri: _('cspect.context.inherited'),
                report_to: _('cspect.context.inherited'),
                reporting_endpoints:  _('cspect.context.inherited'),
            };
        }
        if (panel.config.key === 'mgr') {
            panel.config.record = record;
            panel.getForm().setValues(record);
            return;
        }
        MODx.Ajax.request({
            url: cspect.config.connectorUrl,
            params: {
                action: 'CSPect\\Processors\\Contexts\\GetItem',
                context_key: panel.config.key
            },
            listeners: {
                success: {
                    fn: function (response) {
                        if (response.success) {
                            Ext.each(response.results, function (item) {
                                // eg. {cspect.report_to: 'cspect'}
                                var key = Object.keys(item)[0];
                                var value = item[key];
                                // eg. {report_to: 'cspect'}
                                key = key.replace('cspect.', '');
                                record[key] = value;
                                console.log(record);
                            });
                            panel.config.record = record;
                            panel.getForm().setValues(record);
                        }
                    },
                    scope: this
                }
            }
        });
    },
});

Ext.reg('cspect-panel-context', cspect.panel.Context);