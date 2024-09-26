cspect.page.Directive = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        formpanel: 'cspect-panel-directive',
        buttons: [
            {
                text: _('cancel'),
                params: { a: 'manage', namespace: 'cspect' }
            },
            {
                text: _('save') + ' <i class="icon icon-check"></i>',
                cls: 'primary-button',
                method: 'remote',
                url: cspect.config.connectorUrl,
                process: 'CSPect\\Processors\\Directives\\Update',
                keys: [
                    {
                        key: MODx.config.keymap_save || 's',
                        ctrl: true
                    }
                ]
            }
        ],
        components: [
            {
                xtype: 'cspect-panel-directive',
                renderTo: 'cspect-panel-manage-div'
            }
        ]
    });
    cspect.page.Directive.superclass.constructor.call(this, config);
};
Ext.extend(cspect.page.Directive, MODx.Component);
Ext.reg('cspect-page-directive', cspect.page.Directive);
