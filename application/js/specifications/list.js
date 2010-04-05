App.specifications.list = function () {

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
                text: 'Add',
                iconCls: 'app-btn-add',
                listeners: {
                    click : function () {
                        App.features.encode();
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
            },
            '->',
            {
                xtype : 'button',
                iconCls : 'app-btn-find',
                text : 'View All Features'
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
            { header: 'Name', dataIndex: 'name', width : 120},
            { header: 'Description', dataIndex: 'description', width : 500},
            { header: 'Badge File', dataIndex: 'badge_file', width : 120},
            { header: 'active', dataIndex: 'active' }
        ],
        listeners: {
            rowdblclick: function (t, idx) {
                var data = feature_ds.getAt(idx).data;
                App.features.encode(data);
            }
        }
    });

    var cmp = new Ext.Panel({
        title: 'Specification List',
        id : 'App.specifications.list',
        items: [ features_grid ],
        layout: 'border'
    });

    return cmp;

};