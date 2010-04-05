App.product.list = function () {

    var product_ds = new Ext.data.JsonStore({
        fields: ['id', 'product_code','product_name','short_description',
            'description',
            { name : 'active', type : 'bool'}
        ],
        root: 'data',
        url: '/products/get-product-list',
        autoLoad : true
    });

    var product_tbar = new Ext.Toolbar({
        items : [
            {
                xtype: 'button',
                text: 'Add',
                iconCls: 'app-btn-add',
                listeners: {
                    click : function () {
                        App.product.encode();
                    }
                }
            },
            '-',
            {
                xtype: 'button',
                text: 'Delete',
                iconCls: 'app-btn-delete',
                listeners: {
                    click : function () {
                        var sm = product_grid.getSelectionModel();
                        if (sm.hasSelection()) {
                            var sel = sm.getSelected();
                            Ext.Ajax.request({
                                url : '/products/delete',
                                params : {
                                    id : sel.data.id
                                },
                                success : function(resp){
                                    var response = Ext.decode(resp.responseText);
                                    if (response.success){
                                        product_ds.load();
                                    }
                                }
                            });
                        }
                    }
                }
            }
        ]
    });

    var expander = new Ext.ux.grid.RowExpander({
        tpl : new Ext.Template(
            '<p><b>Product Name:</b> {product_name}</p><br>',
            '<p><b>Description:</b> {description}</p>'
        )
    });

    var product_grid = new Ext.grid.GridPanel({
        region: 'center',
        title : 'Product List',
        plugins: expander,
        ds: product_ds,
        tbar : product_tbar,
        viewConfig: {
            emptyText: 'No available records found.'
        },
        columns: [
            expander,
            {header: 'Product Code', dataIndex: 'product_code'},
            {header: 'Product Name', dataIndex: 'product_name', width : 200},
            {header: 'Short Description', dataIndex: 'short_description', width : 200},
            {header: 'Active', dataIndex: 'active'}
        ],
        listeners: {
            rowdblclick: function (t, idx) {
                var data = product_ds.getAt(idx).data;
                App.product.encode(data);
            }
        }
    });

    var cmp = new Ext.Panel({
        title: 'Product List',
        id : 'App.product.list',
        items: [ product_grid ],
        layout: 'border'
    });

    return cmp;

};