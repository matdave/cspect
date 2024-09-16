cspect.grid.Source = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        url: cspect.config.connectorUrl,
        baseParams: {
            action: 'CSPect\\Processors\\Sources\\GetList',
            sort: 'rank',
            dir: 'asc'
        },
        fields: ['id', 'name', 'rank'],
        columns: [
            {
                header: _('cspect.global.name'),
                dataIndex: 'name',
                sortable: true,
                width: 100,
            },
        ],
        tbar: [
            {
                text: _('cspect.source_create'),
                handler: this.createSource
            }
        ],
        autoHeight: true,
        paging: true,
        remoteSort: true,
        enableDragDrop: false,
        autoExpandColumn: 'name',
    });
    cspect.grid.Source.superclass.constructor.call(this, config);
}

Ext.extend(cspect.grid.Source, MODx.grid.Grid, {
    createSource: function () {
        var record = {
            name: '',
            create: true
        }
        var win = MODx.load({
            xtype: 'cspect-window-source'
        });
        win.setValues(record);
        win.show();
    }
});
Ext.reg('cspect-grid-source', cspect.grid.Source);