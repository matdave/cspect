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
    createSource: function (btn, e) {
        var record = {
            name: ''
        }
        var createSource = MODx.load({
            xtype: 'cspect-window-source',
            record: record,
            isUpdate: false,
            listeners: {
                success: {
                    fn: function() {
                        this.refresh();
                    },
                    scope: this
                }
            }
        });
        createSource.fp.getForm().setValues(record);
        createSource.show(e.target);
        return true;
    }
});
Ext.reg('cspect-grid-source', cspect.grid.Source);