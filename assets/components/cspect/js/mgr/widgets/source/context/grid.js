cspect.grid.SourceContext = function (config) {
    config = config || {
        source: {
            id: 0,
            name: "",
        },
        context: {
            key: "",
        }
    }

    Ext.apply(config, {
        url: cspect.config.connectorUrl,
        baseParams: {
            action: 'CSPect\\Processors\\SourceContexts\\GetList',
            source: (config.source) ? config.source.id || null : null,
            context_key: (config.context) ? config.context.key || null : null,
        },
        fields: ['id', 'source', 'source_name', 'context_key', 'context_name'],
        columns: [
            {
                header: _('id'),
                dataIndex: 'id',
                sortable: true,
                hidden: true
            },
            {
                header: _('cspect.source'),
                dataIndex: 'source_name',
                sortable: true,
                width: 100,
                hidden: !!(config.source)
            },
            {
                header: _('cspect.context'),
                dataIndex: 'context_key',
                sortable: true,
                width: 100,
                hidden: !!(config.context),
                renderer: function (v, md, r) {
                   return r.data.context_name || v;
                }
            },
            {
                header: _('cspect.source') + ' ' + _('id'),
                dataIndex: 'source',
                sortable: true,
                width: 100,
                hidden: true
            },
        ],
        tbar: this.getTbar(config),
        autoHeight: true,
        paging: true,
        remoteSort: true,
    });

    cspect.grid.SourceContext.superclass.constructor.call(this, config);
}
Ext.extend(cspect.grid.SourceContext, MODx.grid.Grid, {
    getTbar: function (config) {
        var t = [];
        t.push({
            text: (config.context) ?
                _('cspect.sourcecontext_create.source') :
                _('cspect.sourcecontext_create.context'),
            handler: this.createSourceContext
        });
        return t;
    },
    getMenu() {
        var menu = [];
        if (this.config.source) {
            menu.push({
                text: _('cspect.context_update'),
                handler: this.updateContext
            })
        }

        if (this.config.context) {
            menu.push({
                text: _('cspect.source_update'),
                handler: this.updateSource
            });
        }

        menu.push({
            text: _('cspect.global.remove'),
            handler: this.removeSourceContext
        });
        return menu;
    },
    updateSource: function(btn, e) {
        cspect.go('source', this.menu.record.source);
    },
    updateContext: function(btn, e) {
        location.href = '?a=context/update&key=' + this.menu.record.context_key;
    },
    removeSourceContext: function(btn, e) {
        MODx.msg.confirm({
            title: _('cspect.sourcecontext_remove'),
            text: _('cspect.sourcecontext_remove_confirm'),
            url: this.config.url,
            params: {
                action: 'CSPect\\Processors\\SourceContexts\\Delete',
                id: this.menu.record.id
            },
            listeners: {
                'success': {fn: function () {
                        this.refresh();
                    }, scope: this}
            }
        });
    },
    createSourceContext: function () {
        var win = MODx.load({
            xtype: 'cspect-window-sourcecontext-create',
            context: this.config.context,
            source: this.config.source,
            listeners: {
                'success': {fn: function () {
                        this.refresh();
                    }, scope: this}
            }
        });
        win.fp.getForm().reset();
        win.show();
    }
});
Ext.reg('cspect-grid-sourcecontext', cspect.grid.SourceContext);