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
                        title: _('cspect.manage.page_title'),
                        layout: 'form',
                        items: [
                            {
                                cls: 'main-wrapper',
                               html: 'Greetings from John. Thank you for using GPM.'
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
