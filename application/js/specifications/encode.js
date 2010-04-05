App.specifications.encode = function (params) {

    var btnSave = new Ext.Button({
        text: 'Save',
        iconCls: 'app-btn-save',
        handler: function () {
            if (form.getForm().isValid()) {
                form.getForm().submit({
                    url : '/features/new',
                    success : function() {
                        Ext.Msg.show({
                           title    : 'Success',
                           msg      : 'New record successfully saved.',
                           buttons  : Ext.Msg.OK,
                           animEl   : 'elId',
                           icon     : Ext.MessageBox.INFO
                        });
                    },
                    failure : function(f, a) {
                        Ext.Msg.alert('Result', a.result.msg);
                    }
                });
            }
        }
    });

    var form = new Ext.form.FormPanel({
        bodyStyle  : 'padding: 10px 10px',
        frame: true,
        defaults : {
            width : 250,
            allowBlank : false
        },
        fileUpload : true,
        items : [
            {
                xtype : 'textfield',
                fieldLabel : 'Name',
                name : 'name'
            },
            {
                xtype : 'fileuploadfield',
                fieldLabel : 'Badge File',
                id: 'badge_file',
                name : 'badge_file',
                emptyText: 'Select an image'
            },
            {
                xtype : 'textarea',
                anchor : '100%',
                fieldLabel : 'Description',
                name : 'description',
                height : 100
            },
            {
                xtype: 'radiogroup',
                border : true,
                name : 'active',
                fieldLabel : 'Active',
                items: [
                    { boxLabel: 'Yes', name: 'active', inputValue: 1, checked: true },
                    { boxLabel: 'No' , name: 'active' , inputValue: 0 },
                ],
                width : 120
            }
        ],
        buttons : [ btnSave ]
    });

    if (Ext.isDefined(params)) {
        if (Ext.isDefined(params.id)) {
            form.getForm().load({
                url: '/products/get-product',
                params: {
                    id: params.id
                }
            });
        }
    }

    var cmp = new Ext.Window({
        title   : 'Add New Features',
        layout  : 'fit',
        height  : 280,
        width   : 500,
        border  : false,
        items   : [ form ]
    });
    
    cmp.show();
    
    return cmp;
    
};