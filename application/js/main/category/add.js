App.category.add = function () {

    var category_ds = new Ext.data.JsonStore({
        fields: ['id', 'category'],
        root: 'data',
        url: '/category/get-category-list',
        autoLoad : true
    });

    var category_tbar = new Ext.Toolbar({
        items : [
            {
                xtype: 'button',
                text: 'Add',
                iconCls: 'app-btn-add',
                listeners: {
                    click : function () {
                        Ext.Msg.prompt('Add Category', 'Please enter new Category name:', function(btn, text){
                            if (btn == 'ok'){
                                if (! (text == "")){
                                    Ext.Ajax.request({
                                        url : '/category/new',
                                        params : {
                                            category : text
                                        },
                                        success : function() {
                                            category_ds.load();
                                        }
                                    });
                                } else {
                                    Ext.Msg.alert('Error', 'Empty value not allowed.');
                                }
                            }
                        });
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
                        var sm = category_grid.getSelectionModel();
                        if (sm.hasSelection()) {
                            var sel = sm.getSelected();
                            Ext.Ajax.request({
                                url : '/category/delete',
                                params : {
                                    id : sel.data.id
                                },
                                success : function(resp){
                                    var response = Ext.decode(resp.responseText);
                                    if (response.success){
                                        category_ds.load();
                                    }
                                }
                            });
                        }
                    }
                }
            }
        ]
    });

    var category_sm = new Ext.grid.RowSelectionModel({
        listeners : {
            rowSelect : function(a,index,r){
                member_ds.load({
                    params : {
                        category_id : r.data.id
                    }
                });
                product_ds.load();
            }
        }
    });

    var category_grid = new Ext.grid.EditorGridPanel({
        region  : 'west',
        title   : 'Category List',
        ds : category_ds,
        tbar : category_tbar,
        sm : category_sm,
        viewConfig: {
            emptyText: 'No available records found.'
        },
        columns: [
            { header: 'Category Name', dataIndex: 'category', width : 240 , editor: new Ext.form.TextField()},
        ],
        width : 250,
        listeners : {
            afteredit: function (e) {
                var id = e.record.data.id;
                var category = e.value;

                Ext.Ajax.request({
                    url: '/category/edit',
                    params: {
                        category_id : id,
                        category : category
                    },
                    success: function (r) {
                        var response = Ext.decode(r.responseText);
                        if (response.success) {
                            e.record.commit();
                        } else {
                            e.record.reject();
                        }
                    }
                });
            }
        }
    });

    var member_ds = new Ext.data.JsonStore({
        fields: ['id', 'product_name' ],
        root: 'data',
        url: '/category/get-members'
    });

    var member_tbar = new Ext.Toolbar({
        items : [
            {
                xtype: 'button',
                text: 'Remove from Category',
                iconCls: 'app-btn-arrow-right',
                handler : function() {
                    var member_sm = member_grid.getSelectionModel();
                    if (member_sm.hasSelection()) {
                        var sel = member_sm.getSelected();
                        member_ds.remove(sel);
                        Ext.Ajax.request({
                            url : '/category/remove-member',
                            params : {
                                product_id : sel.data.id
                            },
                            success : function(resp){
                                var res = Ext.decode(resp.responseText);
                                if (res.success){
                                    product_ds.load();
                                    sel.commit();
                                }
                            }
                        });
                    } else {
                        Ext.Msg.show({
                           title    : 'Error',
                           msg      : 'No category selected.',
                           buttons  : Ext.Msg.OK,
                           animEl   : 'elId',
                           icon     : Ext.MessageBox.INFO
                        });
                    }
                }
            }
        ]
    });

    var member_grid = new Ext.grid.GridPanel({
        region: 'west',
        title : 'Category Members',
        ds: member_ds,
        tbar : member_tbar,
        viewConfig: {
            emptyText: 'No available records found.'
        },
        columns: [
            { header: 'Product Name', dataIndex: 'product_name', width : 200 }
        ]
    });

    var product_ds = new Ext.data.JsonStore({
        fields: ['id', 'product_code','product_name','short_description',
            'description',
            { name : 'active', type : 'bool'}
        ],
        root: 'data',
        url: '/category/get-Nonmember-Products',
        autoLoad : true
    });

    var product_tbar = new Ext.Toolbar({
        items : [
             {
                xtype: 'button',
                text: 'Add to Category',
                iconCls: 'app-btn-arrow-left',
                handler : function() {
                    var product_sm = product_grid.getSelectionModel();
                    var category_sm = category_grid.getSelectionModel();
                    if (product_sm.hasSelection() && category_sm.hasSelection()) {
                        var sel = product_sm.getSelected();
                        var sel2 = category_sm.getSelected();
                        member_ds.add(sel);
                        Ext.Ajax.request({
                            url : '/category/add-member',
                            params : {
                                product_id : sel.data.id,
                                category_id : sel2.data.id
                            },
                            success : function(resp){
                                var res = Ext.decode(resp.responseText);
                                sel.commit();
                                product_ds.loadData(res);
                            }
                        });
                    } else {
                        Ext.Msg.show({
                           title    : 'Error',
                           msg      : 'No Selected Category or Product.',
                           buttons  : Ext.Msg.OK,
                           animEl   : 'elId',
                           icon     : Ext.MessageBox.INFO
                        });
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
        region: 'west',
        title : 'Product List',
        ds: product_ds,
        tbar : product_tbar,
        plugins :expander,
        viewConfig: {
            emptyText: 'No available records found.'
        },
        columns: [
            expander,
            {header: 'Product Code', dataIndex: 'product_code'},
            {header: 'Product Name', dataIndex: 'product_name', width : 200},
            {header: 'Short Description', dataIndex: 'short_description', width : 200},
            {header: 'Active', dataIndex: 'active'}
        ]
    });

    var cmp = new Ext.Panel({
        title: 'Categories',
        id : 'App.category.add',
        items: [ category_grid,
            {
                layout  : 'border',
                region  : 'center',
                border  : false,
                items   : [
                    member_grid,
                    {
                        layout  : 'fit',
                        region  : 'center',
                        border  : false,
                        items   : [ product_grid ]
                    }
                ]
            }
        ],
        layout: 'border'
    });

    return cmp;

};