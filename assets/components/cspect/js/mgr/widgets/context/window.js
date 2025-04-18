cspect.window.ContextExport = function (config) {
    config = config || {};
    config.exportData = config.exportData || '';
    Ext.applyIf(config, {
        title: _('cspect.context.export'),
        width: 800,
        autoHeight: true,
        modal: true,
        maximizable: true,
        shadow: true,
        layout: 'form',
        cls: 'modx-window',
        anchor: '100% 100%',
        labelAlign: 'top',
        defaults: {
            hideLabel: false,
            anchor: '100%',
        },
        items: [
            {
                fieldLabel: _('cspect.global.csp'),
                xtype: "displayfield",
                html: config.exportData,
                autoScroll: true,
            },
            {
                fieldLabel: _('setting_cspect.reporting_endpoints'),
                xtype: "displayfield",
                html: config.endpoints,
                autoScroll: true,
            }
        ]
    });
    cspect.window.ContextExport.superclass.constructor.call(this, config);
}
Ext.extend(cspect.window.ContextExport, Ext.Window);
Ext.reg('cspect-window-context-export', cspect.window.ContextExport);

cspect.window.ContextImport = function (config) {
    config = config || {};
    config.context_key = config.context_key || '';
    Ext.applyIf(config, {
        title: _('cspect.context.import'),
        url: cspect.config.connectorUrl,
        baseParams: {
            action: 'CSPect\\Processors\\Contexts\\Import',
            context_key: config.context_key
        },
        width: 800,
        modal: true,
        autoHeight: true,
        collapsible: false,
        closeAction: 'close',
        fields: [
            {
                xtype: 'textarea',
                fieldLabel: _('cspect.context.import.csp'),
                name: 'csp',
                anchor: '100%',
                allowBlank: false,
                grow: true,
                growMin: 200
            }
        ]
    });
    cspect.window.ContextImport.superclass.constructor.call(this, config);
}
Ext.extend(cspect.window.ContextImport, MODx.Window);
Ext.reg('cspect-window-context-import', cspect.window.ContextImport);