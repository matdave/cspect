cspect.grid.Directive = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        url: cspect.config.connectorUrl,
        baseParams: {
            action: 'CSPect\\Processors\\Directives\\GetList',
            sort: 'rank',
            dir: 'asc'
        },
        save_action: 'CSPect\\Processors\\Directives\\UpdateFromGrid',
        fields: ['id', 'name', 'description', 'rank'],
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
        autosave: true,
        autoHeight: true,
        paging: true,
        remoteSort: true,
        autoExpandColumn: 'name',
        ddGroup: "cspectDirectiveDDGroup",
        enableDragDrop: true,
    });
    cspect.grid.Directive.superclass.constructor.call(this, config);

    this.on("render", this.registerGridDropTarget, this);
    this.on("beforedestroy", this.destroyScrollManager, this);
    this.on("afterAutoSave", function () {
        this.refresh();
    });
}

Ext.extend(cspect.grid.Directive, MODx.grid.Grid, {
    getMenu: function() {
        var menu = [];
        menu.push({
            text: _('cspect.directive_update'),
            handler: this.updateDirective
        });
        menu.push({
            text: _('cspect.directive_remove'),
            handler: this.removeDirective
        });
        return menu;
    },
    removeDirective: function(btn, e) {
        MODx.msg.confirm({
            title: _('cspect.directive_remove'),
            text: _('cspect.directive_remove_confirm'),
            url: cspect.config.connectorUrl,
            params: {
                action: 'CSPect\\Processors\\Directives\\Delete',
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
    createDirective: function (btn, e) {
        var record = {
            name: '',
            description: '',
        };
        var createDirective = MODx.load({
            xtype: 'cspect-window-directive',
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
        console.log(createDirective);
        createDirective.fp.getForm().setValues(record);
        createDirective.show(e.target);
        return true;
    },
    updateDirective: function (btn, e) {
        cspect.go('directive', this.menu.record.id);
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
                            action: "CSPect\\Processors\\Directives\\DDReorder",
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
Ext.reg('cspect-grid-directive', cspect.grid.Directive);