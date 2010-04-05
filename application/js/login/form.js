App.login.form = function () {
    
     var username = new Ext.form.TextField({
        fieldLabel: 'Username',
        anchor: '100%',
        allowBlank: false,
        name: 'username',
        listeners: {
            afterrender: function (t) {
                t.focus(true, 500);
            }
        }
    });
    
    var password = new Ext.form.TextField({
        fieldLabel: 'Password',
        anchor: '100%',
        allowBlank: false,
        name: 'password',
        inputType: 'password'
    });
    
    var form = new Ext.form.FormPanel({
        items: [ username, password ],
        bodyStyle: 'padding: 5px',
        buttons: [
            {
                text: 'Login',
                handler: function () {
                    if (form.getForm().isValid()) {
                        form.getForm().submit({
                            url: '/auth/login',
                            success: function () {
                                window.location.href = "/main/";
                            },
                            failure: function () {
                                Ext.Msg.alert('Error', 'Access Denied', function () {
                                    form.getForm().reset();
                                });
                            }
                        });
                    }
                }
            }
        ]
    });
    
    return form;
    
};