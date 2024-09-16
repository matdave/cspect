cspect.grid.Directive = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        id: 'cspect-grid-directive',
        url: cspect.config.connectorUrl,
        baseParams: {
            action: 'CSPect\\Processors\\Directives\\GetList'
        },
        fields: ['id', 'name', 'description', 'rank'],
        columns: [
            {
                header: _('cspect.directive_grid_name'),
                dataIndex: 'name',
                sortable: true,
                width: 100,
                renderer: function (value, metaData, record, rowIndex, colIndex, store) {
                    return _('cspect.directive.' + record.data.name)
                }
            },
            {
                header: _('cspect.directive_grid_description'),
                dataIndex: 'description',
                sortable: true,
                width: 100,
                renderer: function (value, metaData, record, rowIndex, colIndex, store) {
                    if (!value) {
                        return _('cspect.directive_desc.' + record.data.name)
                    }
                    return value;
                }
            },
            {
                header: _('cspect.directive_grid_type'),
                dataIndex: 'type',
                sortable: true,
                width: 100
            },
        ],
        tbar: [
            {
                text: _('cspect.directive_grid_create'),
                handler: this.createDirective
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
    cspect.grid.Directive.superclass.constructor.call(this, config);
}

Ext.extend(cspect.grid.Directive, MODx.grid.Grid, {
    createDirective: function () {
        var record = {
            name: '',
            description: '',
            create: true
        };
        var win = MODx.load({
            xtype: 'cspect-window-directive'
        });
        win.setValues(record);
        win.show();
    }
});
Ext.reg('cspect-grid-directive', cspect.grid.Directive);