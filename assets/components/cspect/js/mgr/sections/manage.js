cspect.page.Manage = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        components: [
            {
                xtype: 'cspect-panel-manage',
                renderTo: 'cspect-panel-manage-div'
            }
        ]
    });
    cspect.page.Manage.superclass.constructor.call(this, config);
};
Ext.extend(cspect.page.Manage, MODx.Component);
Ext.reg('cspect-page-manage', cspect.page.Manage);
