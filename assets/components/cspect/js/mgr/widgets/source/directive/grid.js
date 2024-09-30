cspect.grid.SourceDirective = function (config) {
    config = config || {
        directive: {
            id: 0,
            name: "",
        },
        source: {
            id: 0,
            name: "",
        }
    };

    Ext.apply(config, {
        url: cspect.config.connectorUrl,
        baseParams: {
            action: 'CSPect\\Processors\\SourceDirectives\\GetList',
            directive: (config.directive) ? config.directive.id || null : null,
            source: (config.source) ? config.source.id || null : null,
        },
        fields: ['id', 'source', 'directive', 'source_name', 'directive_name'],
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
                header: _('cspect.directive'),
                dataIndex: 'directive_name',
                sortable: true,
                width: 100,
                hidden: !!(config.directive),
                renderer: function (v, md, r) {
                    return _('cspect.directive.' + v);
                }
            },
            {
                header: _('cspect.source') + ' ' + _('id'),
                dataIndex: 'source',
                sortable: true,
                width: 100,
                hidden: true
            },
            {
                header: _('cspect.directive') + ' ' + _('id'),
                dataIndex: 'directive',
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
    cspect.grid.SourceDirective.superclass.constructor.call(this, config);
}

Ext.extend(cspect.grid.SourceDirective, MODx.grid.Grid, {
    getMenu: function() {
        var menu = [];
        if (this.config.directive) {
            menu.push({
                text: _('cspect.source_update'),
                handler: this.updateSource
            });
        }
        if (this.config.source) {
            menu.push({
                text: _('cspect.directive_update'),
                handler: this.updateDirective
            });
        }
        menu.push({
            text: _('cspect.global.remove'),
            handler: this.removeSourceDirective
        });
        return menu;
    },
    getTbar: function (config) {
        var t = [];
        t.push({
            text: (config.directive) ?
                _('cspect.sourcedirective_create.source') :
                _('cspect.sourcedirective_create.directive'),
            handler: this.createSourceDirective
        });
        return t;
    },
    updateSource: function(btn, e) {
        cspect.go('source', this.menu.record.source);
    },
    updateDirective: function(btn, e) {
        cspect.go('directive', this.menu.record.directive);
    },
    removeSourceDirective: function(btn, e) {
        MODx.msg.confirm({
            title: _('cspect.global.remove'),
            text: _('cspect.global.remove_confirm'),
            url: cspect.config.connectorUrl,
            params: {
                action: 'CSPect\\Processors\\SourceDirectives\\Delete',
                id: this.menu.record.id
            },
            listeners: {
                'success': {fn: function () {
                        this.refresh();
                    }, scope: this}
            }
        });
    },
    createSourceDirective: function () {
        var win = MODx.load({
            xtype: 'cspect-window-sourcedirective-create',
            directive: this.config.directive,
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

Ext.reg('cspect-grid-sourcedirective', cspect.grid.SourceDirective);