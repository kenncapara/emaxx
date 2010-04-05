App.product.encode = function (params) {
    
    var product = new Ext.form.FieldSet({
        title : 'Product Information'
    });

    var btnSave = new Ext.Button({
        text: 'Save',
        iconCls: 'app-btn-save',
        handler: function () {
            if ( Ext.isDefined(params)){
                if (Ext.isDefined(params.id)) {
                    form.getForm().submit({
                        url: '/products/edit',
                        params : {
                            id : params.id
                        },
                        success: function() {
                            Ext.Msg.show({
                               title    : 'Success',
                               msg      : 'Update successfully saved.',
                               buttons  : Ext.Msg.OK,
                               animEl   : 'elId',
                               icon     : Ext.MessageBox.INFO
                            });
                        }
                    });
                }
            } else {
                form.getForm().submit({
                    url: '/products/new',
                    success: function() {
                        Ext.Msg.show({
                           title    : 'Success',
                           msg      : 'New record successfully saved.',
                           buttons  : Ext.Msg.OK,
                           animEl   : 'elId',
                           icon     : Ext.MessageBox.INFO
                        });
                    }
                });
            }
        }
    });

    var form = new Ext.form.FormPanel({
        bodyStyle  : 'padding: 10px 10px',
        frame   : true,
        defaults : {
            width : 250,
            allowBlank : false
        },
        items : [
            {
                xtype : 'textfield',
                fieldLabel : 'Product Code',
                name : 'product_code',
                width : 120
            },
            {
                xtype : 'textfield',
                fieldLabel : 'Product Name',
                name : 'product_name'
            },
            {
                xtype : 'textfield',
                fieldLabel : 'Short Description',
                name : 'short_description'
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
                    {boxLabel: 'Yes', name: 'active', inputValue: 1, checked: true},
                    {boxLabel: 'No' , name: 'active' , inputValue: 0},
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
        title   : 'Add New Product',
        layout  : 'fit',
        border  : false,
        height  : 300,
        width   : 500,
        items   : [ form ]
    });
    
    cmp.show();
    
    return cmp;
    
};