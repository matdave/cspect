cspect.grid.Source = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        url: cspect.config.connectorUrl,
        baseParams: {
            action: 'CSPect\\Processors\\Sources\\GetList',
            sort: 'rank',
            dir: 'asc'
        },
        save_action: 'CSPect\\Processors\\Sources\\UpdateFromGrid',
        fields: ['id', 'name', 'rank'],
        columns: [
            {
                header: _('id'),
                dataIndex: 'id',
                sortable: true,
                hidden: true
            },
            {
                header: _('cspect.global.rank'),
                dataIndex: 'rank',
                sortable: true,
                hidden: true,
                editor: {
                    xtype: 'numberfield',
                    allowNegative: false,
                    allowDecimals: false
                }
            },
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
        autosave: true,
        autoHeight: true,
        paging: true,
        remoteSort: true,
        autoExpandColumn: 'name',
        ddGroup: "cspectSourceDDGroup",
        enableDragDrop: true,
    });
    cspect.grid.Source.superclass.constructor.call(this, config);

    this.on("render", this.registerGridDropTarget, this);
    this.on("beforedestroy", this.destroyScrollManager, this);
    this.on("afterAutoSave", function () {
        this.refresh();
    });
}

Ext.extend(cspect.grid.Source, MODx.grid.Grid, {
    getMenu: function() {
        var menu = [];
        menu.push({
            text: _('cspect.source_update'),
            handler: this.updateSource
        });
        menu.push({
            text: _('cspect.source_remove'),
            handler: this.removeSource
        });
        return menu;
    },
    removeSource: function(btn, e) {
        MODx.msg.confirm({
            title: _('cspect.source_remove'),
            text: _('cspect.source_remove_confirm'),
            url: cspect.config.connectorUrl,
            params: {
                action: 'CSPect\\Processors\\Sources\\Delete',
                id: this.menu.record.id,
            },
            listeners: {
                success: {
                    fn: function() {
                        this.refresh();
                    },
                    scope: this
                }
            }
        });
    },
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
    },
    registerGridDropTarget: function () {
        var ddrow = new Ext.ux.dd.GridReorderDropTarget(this, {
            copy: false,
            sortCol: "rank",
            listeners: {
                beforerowmove: function (objThis, oldIndex, newIndex, records) {},

                afterrowmove: function (objThis, oldIndex, newIndex, records) {
                    MODx.Ajax.request({
                        url: MODx.config.connector_url,
                        params: {
                            action: "CSPect\\Processors\\Sources\\DDReorder",
                            idItem: records.pop().id,
                            oldIndex: oldIndex,
                            newIndex: newIndex,
                            location: MODx.request.id,
                        },
                        listeners: {
                            success: {
                                fn: function (r) {
                                    this.target.grid.refresh();
                                },
                                scope: this,
                            },
                        },
                    });
                },

                beforerowcopy: function (objThis, oldIndex, newIndex, records) {},

                afterrowcopy: function (objThis, oldIndex, newIndex, records) {},
            },
        });

        Ext.dd.ScrollManager.register(this.getView().getEditorParent());
    },

    destroyScrollManager: function () {
        Ext.dd.ScrollManager.unregister(this.getView().getEditorParent());
    },

    getDragDropText: function () {
        if (this.config.baseParams.sort !== "rank") {
            if (this.store.sortInfo === undefined || this.store.sortInfo.field !== "rank") {
                return _("cspect.err.bad_sort_column", { column: "rank" });
            }
        }

        return _("cspect.global.change_order", {
            child: this.selModel.selections.items[0].data.game_name,
        });
    },
});
Ext.reg('cspect-grid-source', cspect.grid.Source);