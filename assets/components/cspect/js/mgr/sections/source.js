cspect.page.Source = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        formpanel: 'cspect-panel-source',
        buttons: [
            {
                text: _('cancel'),
                params: { a: 'manage', namespace: 'cspect' }
            }
        ],
        components: [
            {
                xtype: 'cspect-panel-source',
                renderTo: 'cspect-panel-manage-div'
            }
        ]
    });
    cspect.page.Source.superclass.constructor.call(this, config);
};
Ext.extend(cspect.page.Source, MODx.Component);
Ext.reg('cspect-page-source', cspect.page.Source);
