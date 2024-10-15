cspect.panel.ContextVTabs = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        id: 'cspect-panel-context-vtabs',
        cls: 'cspect-panel-context-vtabs',
        baseCls: 'x-plain',
        border: false,
        autoScroll: true,
        items: [
            {
                xtype: 'modx-vtabs',
                deferredRender: true,
                activeTab: 0,
                items: [{
                    xtype: 'cspect-panel-context',
                    title: '<i class="icon icon-sun-o"></i> ' + _('cspect.context.global'),
                    key: 'mgr',
                    description: _('cspect.context.global_desc'),
                }],
                listeners: {
                    'beforerender': function (panel) {
                        this.getContextTabs(panel);
                    },
                    scope: this
                }
            }
        ]
    });
    cspect.panel.ContextVTabs.superclass.constructor.call(this, config);
}
Ext.extend(cspect.panel.ContextVTabs, MODx.Panel, {
    getContextTabs: async function (panel) {
        var contexts = [];
        await MODx.Ajax.request({
            url: cspect.config.connectorUrl,
            params: {
                action: 'CSPect\\Processors\\Contexts\\GetList',
                ignore_key: 'mgr'
            },
            listeners: {
                success: {
                    fn: function (response) {
                        if (response.success) {
                            var tabs = [];
                            Ext.each(response.results, function (context) {
                                tabs.push({
                                    title: '<i class="icon icon-globe"></i> ' +
                                        ( context.name !== '' ? context.name : context.key ),
                                    xtype: 'cspect-panel-context',
                                    ...context
                                });
                            });
                            panel.add(tabs);
                            panel.setActiveTab(0);
                        }
                    },
                    scope: this
                }
            }
        });
    },
});
Ext.reg('cspect-panel-context-vtabs', cspect.panel.ContextVTabs);