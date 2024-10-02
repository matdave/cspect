cspect.window.Violation = function (config) {
    config = config || {};
    Ext.apply(config, {
        title: _('cspect.violation'),
        url: cspect.config.connectorUrl,
        baseParams: {

        },
        collapsible: false,
        width: 800,
        modal: true,
        autoHeight: true,
        closeAction: 'close',
        fields: this.getFields(config),
        buttons: this.getButtons(config)
    });
    cspect.window.Violation.superclass.constructor.call(this, config);
}
Ext.extend(cspect.window.Violation, MODx.Window, {
    getFields: function (config) {
        var fields = [
            {
                xtype: 'hidden',
                name: 'id',
            },
            {
                xtype: 'displayfield',
                fieldLabel: _('cspect.violation.user_agent'),
                name: 'user_agent',
            },
            {
                xtype: 'displayfield',
                fieldLabel: _('cspect.global.created_on'),
                name: 'created_on',
            },
        ];
        if (config.record.body) {
            var body = config.record.body;
            for (var key in body) {
                if (body.hasOwnProperty(key) && body[key]) {
                    fields.push({
                        xtype: 'displayfield',
                        fieldLabel: _('cspect.violation.body.' + key),
                        name: 'body_' + key + '',
                        value: body[key],
                    });
                }
            }
        }
        return fields;
    },
    getButtons(config) {
        var buttons = [];

        if (
            config.record.context_key &&
            config.record.directive &&
            !['report-uri', 'report-to', 'sandbox', 'unknown'].includes(config.record.directive) &&
            config.record.blocked
        ) {
            buttons.push({
                text: _('cancel'),
                scope: this,
                handler: function() {this.close()}
            });
            buttons.push({
                text: _('cspect.violation.auto_fix'),
                cls: 'primary-button',
                scope: this,
                handler: function () {
                    MODx.msg.confirm({
                        title: _('cspect.violation.auto_fix'),
                        text: _('cspect.violation.auto_fix_confirm'),
                        url: cspect.config.connectorUrl,
                        params: {
                            action: 'CSPect\\Processors\\Violations\\AutoFix',
                            directive: config.record.directive,
                            context_key: config.record.context_key,
                            blocked: config.record.blocked,
                        },
                        listeners: {
                            success: {
                                fn: function() {
                                    this.fireEvent('success');
                                    this.close();
                                },
                                scope: this
                            }
                        }
                    });
                }
            });
        } else {
            buttons.push({
                text: _('cspect.violation.auto_fix_unavailable'),
                scope: this,
                handler: function() {this.close()}
            });
        }
        return buttons;
    }
});
Ext.reg('cspect-window-violation', cspect.window.Violation);