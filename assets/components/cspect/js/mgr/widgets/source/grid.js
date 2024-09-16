cspect.grid.Source = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        id: 'cspect-grid-source',
        url: cspect.config.connectorUrl,
        baseParams: {action: 'CSPect\\Processors\\Sources\\GetList'},
        fields: ['id', 'name', 'rank'],
        columns: [
            {
                header: _('cspect.source_grid_name'),
                dataIndex: 'name',
                sortable: true,
                width: 100,
                renderer: function (value, metaData, record, rowIndex, colIndex, store) {
                    return _('cspect.source.' + record.data.name)
                }
            },
        ],
        tbar: [
            {
                text: _('cspect.source_grid_create'),
                handler: this.createSource
            }
        ],
        autoHeight: true,
        paging: true,
        remoteSort: true,
        enableDragDrop: false,
        selModel: new Ext.grid.RowSelectionModel({singleSelect: true}),
        autoExpandColumn: 'name',
        listeners: {
            'render': {fn: function (grid) {
                var store = grid.getStore();
                store.load();
            }, scope: this}
        }
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