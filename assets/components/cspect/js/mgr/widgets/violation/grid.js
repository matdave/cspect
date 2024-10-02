cspect.grid.Violation = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        url: cspect.config.connectorUrl,
        baseParams: {
            action: 'CSPect\\Processors\\Violations\\GetList',
            sort: 'created_on',
            dir: 'desc'
        },
        fields: ['id', 'context_key', 'age', 'type', 'url', 'user_agent', 'created_on', 'body', 'directive', 'blocked'],
        columns: [
            {
                header: _('id'),
                dataIndex: 'id',
                sortable: true,
                hidden: true
            },
            {
                header: _('cspect.context'),
                dataIndex: 'context_key',
                sortable: true,
                width: 40,
            },
            {
                header: _('cspect.violation.age'),
                dataIndex: 'age',
                sortable: true,
                hidden: true,
                width: 40,
            },
            {
                header: _('cspect.violation.directive'),
                dataIndex: 'directive',
                sortable: true,
                width: 40,
            },
            {
                header: _('cspect.violation.blocked'),
                dataIndex: 'blocked',
                sortable: true,
                width: 100,
            },
            {
                header: _('cspect.violation.type'),
                dataIndex: 'type',
                sortable: true,
                hidden: true,
                width: 100,
            },
            {
                header: _('cspect.global.url'),
                dataIndex: 'url',
                sortable: true,
                width: 100,
            },
            {
                header: _('cspect.violation.user_agent'),
                dataIndex: 'user_agent',
                sortable: true,
                hidden: true,
                width: 100,
            },
            {
                header: _('cspect.global.created_on'),
                dataIndex: 'created_on',
                sortable: true,
                width: 100,
            },
            {
                header: _('cspect.violation.body'),
                dataIndex: 'body',
                sortable: true,
                hidden: true,
                width: 200,
                renderer: function (value) {
                    // convert object to string
                    if (typeof value === 'object') {
                        value = JSON.stringify(value);
                    }
                    // truncate string
                    if (value.length > 155) {
                        value = value.substring(0, 155) + '...';
                    }
                    return value;
                }
            }
        ],
        autoHeight: true,
        paging: true,
        remoteSort: true,
        autoExpandColumn: 'blocked',
        tbar: [
            {
                text: _('cspect.violation.clear'),
                handler: this.clearViolations
            }
        ],
    });
    cspect.grid.Violation.superclass.constructor.call(this, config);
}
Ext.extend(cspect.grid.Violation, MODx.grid.Grid, {
    getMenu: function() {
        var menu = [];
        menu.push({
            text: _('cspect.violation.view'),
            handler: this.viewViolation
        });
        return menu;
    },
    viewViolation: function () {
        var record = this.menu.record;
        if (record.body) {
            var body = record.body;
            for (var key in body) {
                if (body.hasOwnProperty(key) && body[key]) {
                    record['body_' + key] = body[key];
                }
            }
        }
        var win = MODx.load({
            xtype: 'cspect-window-violation',
            record: record,
            listeners: {
                'success': {fn: function () {
                        this.refresh();
                    }, scope: this}
            }
        });
        win.fp.getForm().reset();
        win.fp.getForm().setValues(record);
        win.show();
    },
    clearViolations: function () {
        MODx.msg.confirm({
            title: _('cspect.violation.clear'),
            text: _('cspect.violation.clear_confirm'),
            url: this.config.url,
            params: {
                action: 'CSPect\\Processors\\Violations\\Clear'
            },
            listeners: {
                'success': {fn: function () {
                        this.refresh();
                    }, scope: this}
            }
        });
    }
});

Ext.reg('cspect-grid-violation', cspect.grid.Violation);