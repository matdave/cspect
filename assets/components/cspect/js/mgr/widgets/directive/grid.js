cspect.grid.Directive = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        url: cspect.config.connectorUrl,
        baseParams: {
            action: 'CSPect\\Processors\\Directives\\GetList',
            sort: 'rank',
            dir: 'asc'
        },
        fields: ['id', 'name', 'description', 'rank'],
        columns: [
            {
                header: _('cspect.global.name'),
                dataIndex: 'name',
                sortable: true,
                width: 100,
                renderer: function (value, metaData, record, rowIndex, colIndex, store) {
                    return _('cspect.directive.' + record.data.name)
                }
            },
            {
                header: _('cspect.global.description'),
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
        ],
        tbar: [
            {
                text: _('cspect.directive_create'),
                handler: this.createDirective
            }
        ],
        autoHeight: true,
        paging: true,
        remoteSort: true,
        enableDragDrop: false,
        autoExpandColumn: 'name',
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