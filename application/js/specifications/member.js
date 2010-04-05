App.specifications.member = function () {


    var feature_ds = new Ext.data.JsonStore({
        fields: ['id', 'name', 'badge_file', 'description',
            { name : 'active', type : 'bool'}
        ],
        root: 'data',
        url: '/features/list',
        autoLoad : true
    });

    var feature_tbar = new Ext.Toolbar({
        items : [
            {
                xtype: 'button',
                text: 'Add to Product',
                iconCls: 'app-btn-add',
                listeners: {
                    click : function () {
                        
                    }
                }
            }
        ]
    });


    var expander = new Ext.ux.grid.RowExpander({
        tpl : new Ext.Template(
            '<br><p><b>Name:</b> {name}</p><br>',
            '<p><b>Description:</b> {description}</p>'
        )
    });

    var features_grid = new Ext.grid.GridPanel({
        title : 'Features List',
        region : 'center',
        ds: feature_ds,
        plugins: expander,
        autoExpandColumn : true,
        tbar : feature_tbar,
        viewConfig: {
            emptyText: 'No available records found.'
        },
        columns: [
            expander,
            { header: 'Name', dataIndex: 'name'},
            { header: 'Description', dataIndex: 'description', width : 350},
            { header: 'Badge File', dataIndex: 'badge_file', width : 120},
            { header: 'active', dataIndex: 'active' }
        ]
    });

    var member_ds = new Ext.data.JsonStore({
        fields: ['id', 'name', 'badge_file', 'description', 
            { name : 'active', type : 'bool'}
        ],
        root: 'data',
        url: '/features/get-features'
    });

    var member_tbar = new Ext.Toolbar({
        items : [
            {
                xtype: 'button',
                text: 'Remove from Product',
                iconCls: 'app-btn-delete',
                listeners: {
                    click : function () {
                        
                    }
                }
            }
        ]
    });


    var expander1 = new Ext.ux.grid.RowExpander({
        tpl : new Ext.Template(
            '<br><p><b>Name:</b> {name}</p><br>',
            '<p><b>Description:</b> {description}</p>'
        )
    });

    var member_grid = new Ext.grid.GridPanel({
        region: 'center',
        title : 'Product Features',
        ds: member_ds,
        tbar : member_tbar,
        plugins: expander1,
        autoExpandColumn : true,
        viewConfig: {
            emptyText: 'No available records found.'
        },
        columns: [
            expander1,
            { header: 'Name', dataIndex: 'name'},
            { header: 'Description', dataIndex: 'description', width : 350},
            { header: 'Badge File', dataIndex: 'badge_file', width : 120},
            { header: 'active', dataIndex: 'active' }
        ]
    });

    var product_ds = new Ext.data.JsonStore({
        fields: ['id', 'product_code','product_name','short_description',
            'description',
            { name : 'active', type : 'bool'}
        ],
        root: 'data',
        url: '/products/get-product-list',
        autoLoad : true
    });

    var product_grid = new Ext.grid.GridPanel({
        region: 'west',
        title : 'Product List',
        ds: product_ds,
        viewConfig: {
            emptyText: 'No available records found.'
        },
        columns: [
            {header: 'Product Name', dataIndex: 'product_name', width : 200}
        ],
        width : 250,
        listeners: {
            rowclick: function (t, idx) {
                var data = product_ds.getAt(idx).data;
                member_ds.load({
                    params : {
                        product_id : data.id
                    }
                });
            }
        }
    });

    var cmp = new Ext.Panel({
        title: 'Product Specifications',
        id : 'App.specifications.member',
        items: [ product_grid,
            {
                layout  : 'border',
                region  : 'center',
                border  : false,
                items   : [
                    member_grid,
                    {
                        layout : 'fit',
                        height : 250,
                        region : 'south',
                        items : [ features_grid]
                    }
                ]
            }
        ],
        layout: 'border'
    });

    return cmp;

};