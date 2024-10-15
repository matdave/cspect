cspect.panel.Manage = function (config) {
    config = config || {};
    Ext.apply(config, {
        border: false,
        baseCls: 'modx-formpanel',
        cls: 'container',
        items: [
            {
                html: '<h2>' + _('cspect.manage.page_title') + '</h2>',
                border: false,
                cls: 'modx-page-header'
            },
            {
                xtype: 'modx-tabs',
                defaults: {
                    border: false,
                    autoHeight: true
                },
                border: true,
                activeItem: 0,
                hideMode: 'offsets',
                items: [
                    {
                        title: _('cspect.manage.directive'),
                        layout: 'form',
                        items: [
                            {
                                html: _('cspect.manage.directive_desc'),
                                cls: 'panel-desc'
                            },
                            {
                                xtype: 'cspect-grid-directive',
                                cls: 'main-wrapper',
                                preventRender: true
                            }
                        ]
                    },
                    {
                        title: _('cspect.manage.source'),
                        layout: 'form',
                        items: [
                            {
                                html: _('cspect.manage.source_desc'),
                                cls: 'panel-desc'
                            },
                            {
                                xtype: 'cspect-grid-source',
                                cls: 'main-wrapper',
                                preventRender: true
                            }
                        ]
                    },
                    {
                        title: _('cspect.manage.violation'),
                        layout: 'form',
                        items: [
                            {
                                html: _('cspect.manage.violation_desc'),
                                cls: 'panel-desc'
                            },
                            {
                                xtype: 'cspect-grid-violation',
                                cls: 'main-wrapper',
                                preventRender: true
                            }
                        ]
                    },
                    {
                        title: _('cspect.manage.context'),
                        layout: 'form',
                        items: [
                            {
                                xtype: 'cspect-panel-context-vtabs',
                                preventRender: false
                            }
                        ]
                    }
                ]
            }
        ]
    });
    cspect.panel.Manage.superclass.constructor.call(this, config);
};
Ext.extend(cspect.panel.Manage, MODx.Panel);
Ext.reg('cspect-panel-manage', cspect.panel.Manage);
