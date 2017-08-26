/*常量*/
var CONSTANT = {
	DATA_TABLES: {
		DEFAULT_OPTION: { //DataTables初始化选项
			"processing": true,
			"serverSide": true,
			"ajax": {
				url: '/Test/GetDataPage',
				type: 'post'
			},
			
			"dom": '<"top"f >rt<"bottom"ilp><"clear">',//dom定位
			"dom": 'tiprl',//自定义显示项
			//"dom":'<"domab"f>',
			//"scrollY": "220px",//dt高度
			"lengthMenu": [
				[10, 20, 30],
				[10, 20, 30]
			],//每页显示条数设置
			"lengthChange": true,//是否允许用户自定义显示数量
			"bPaginate": true, //翻页功能
			"bFilter": false, //列筛序功能
			"searching": true,//本地搜索
			"ordering": true, //排序功能
			"Info": true,//页脚信息
			"autoWidth": true,//自动宽度
			"stripeClasses": ["odd", "even"],//为奇偶行加上样式，兼容不支持CSS伪类的场合
			"oLanguage": {//国际语言转化
				"oAria": {
					"sSortAscending": " : 以升序排列此列",
					"sSortDescending": " : 以降序排列此列"
				},
				"sLengthMenu": "显示 _MENU_ 记录",
				"sZeroRecords": "对不起，查询不到任何相关数据",
				"sEmptyTable": "未有相关数据",
				"sLoadingRecords": "正在加载数据-请等待...",
				"sInfo": "当前显示 _START_ 到 _END_ 条，共 _TOTAL_ 条记录。",
				"sInfoEmpty": "当前显示0到0条，共0条记录",
				"sInfoFiltered": "（数据库中共为 _MAX_ 条记录）",
				"sProcessing": "正在加载数据...",
				"sSearch": "模糊查询：",
				"sUrl": "",
				//多语言配置文件，可将oLanguage的设置放在一个txt文件中，例：Javascript/datatable/dtCH.txt
				"oPaginate": {
					"sFirst": "首页",
					"sPrevious": " 上一页 ",
					"sNext": " 下一页 ",
					"sLast": " 尾页 "
				}
			},
			"pagingType": "full_numbers",	//分页样式
			ajaxType: "post",				//post提交
			autoCheckbox: false,			//自动生成复选框列
			autoOpearte: false,				//自动生成操作列
			searchForm:""					//查询表单
		},
		COLUMN: {
			CHECKBOX: { //复选框单元格
				className: "td-checkbox",
				orderable: false,
				"width":"30px",
				//"data": "Id",
				"render": function (data, type, row, meta) {
				    return '<input type="checkbox" class="iCheck" />';
				    //return '<div class="checkbox"><label><input type="checkbox" class="colored-blue"><span class="text">是|否</span></label></div>';
				}
			},
			OPERATE: {//操作单元格
				className: "td-operate",
				orderable: false,
				//"data": "Id",
				"render": function (data, type, row, meta) {
					return '<button type="button" class="btn btn-small btn-primary btn-edit">修改</button>' +
						'<button type="button" class="btn btn-small btn-danger btn-del">删除</button>';
				}
			}
		},
		RENDER: {   //常用render可以抽取出来，如日期时间、头像等
			ELLIPSIS: function (data, type, row, meta) {
				data = data || "";
				return '<span title="' + data + '">' + data + '</span>';
			}
		}
	}
};


(function(jQuery) {

    jQuery.fn.extend({
        //初始化table
    	customerDataTable: function (options) {

    		options = jQuery.extend({}, CONSTANT.DATA_TABLES.DEFAULT_OPTION,options);
    		options.ajax = {
    			url: options.ajaxUrl,
    			type: options.ajaxType,
    			data: function (d) {
    				if (options.searchForm.length > 0) {
    					
    					d.searchParam = $(options.searchForm).serializeArray();
			        }
			    }
    		};
			//生成复选框列
    		if (options.autoCheckbox) {
                //设置复选列的标识列
    		    var primaryKey = getPrimaryKey(options.columns);
    		    CONSTANT.DATA_TABLES.COLUMN.CHECKBOX.data = primaryKey;
	        	options.columns.unshift(CONSTANT.DATA_TABLES.COLUMN.CHECKBOX);
	        	options.order = [[0, null]];
	        	options.drawCallback = function( settings ) {
	        		//渲染完毕后的回调
	        		//清空全选状态
	        		$(":checkbox[name='cb-check-all']",jQuery(this)).prop('checked', false);
	        		//默认选中第一行
	        		$("tbody tr",jQuery(this)).eq(0).click();
	        	}
	        }
			//生成操作列
    		if (options.autoOpearte) {
    		    //设置操作列的标识列
    		    var primaryKey = getPrimaryKey(options.columns);
    		    CONSTANT.DATA_TABLES.COLUMN.OPERATE.data = primaryKey;
	        	options.columns.push(CONSTANT.DATA_TABLES.COLUMN.OPERATE);
	        }
	       

	       /* return this.each(function() {
	        	var dtApi = dataTableManager.initDataTable(jQuery(this), options);
	            console.log(dtApi);
	        });*/
	        return dataTableManager.initDataTable(jQuery(this), options);

    	}
    });

    ///获取标识列
    function getPrimaryKey(columns) {
        var primaryKey = 'Id';
        $.each(columns, function (index, item) {
            if (item.primary === true) {
                primaryKey = item.data;
                return;
            }
        });
        return primaryKey;
    }

})(jQuery);

var dataTableManager = {
	fuzzySearch: true,
	initDataTable: function (container, opt) {
		
		var dtApi = container.DataTable(opt);
	    container.on("change", ":checkbox", function() {
	        if ($(this).is("[name='cb-check-all']")) {
	            //全选
	            $(":checkbox", container).prop("checked", $(this).prop("checked"));
	        } else {
	            //一般复选
	            var checkbox = $("tbody :checkbox", container);
	            $(":checkbox[name='cb-check-all']", container).prop('checked', checkbox.length === checkbox.filter(':checked').length);
	        }
	    }).on("click", ".td-checkbox", function(event) {
	        //点击单元格即点击复选框
	        !$(event.target).is(":checkbox") && $(":checkbox", this).trigger("click");
	    }).on("click",".btn-edit",function() {
	    	//点击编辑按钮
	    	var item = dtApi.row($(this).closest('tr')).data();
	    	$(this).closest('tr').addClass("active").siblings().removeClass("active");
	    	if (opt.editFunc != undefined) {
	    	    opt.editFunc(item);
	        }
	    }).on("click",".btn-del",function() {
	    	//点击删除按钮
	    	var item = dtApi.row($(this).closest('tr')).data();
	    	$(this).closest('tr').addClass("active").siblings().removeClass("active");
	    	if (opt.delFunc != undefined) {
	    	    opt.delFunc(item);
	        }
	    });
	    return dtApi;
	}
};