@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
    GUI CRUD Builder
    @parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <link href="{{ asset('assets/vendors/select2/css/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/vendors/iCheck/css/all.css') }}" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/sweetalert/css/sweetalert.css') }}"/>
    <link href="{{ asset('assets/vendors/bootstrapvalidator/css/bootstrapValidator.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('assets/css/pages/custom_gui_builder.css') }}" rel="stylesheet" />
@stop

{{-- Page content --}}
@section('content')
    <section class="content-header">
        <h1>GUI CRUD Generator</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('dashboard') }}">
                    <i class="livicon" data-name="home" data-size="14" data-c="#000"></i>
                    Dashboard
                </a>
            </li>
            <li><a href="#">GUI CRUD Generator</a></li>
            <li class="active">Generator Builder</li>
        </ol>
    </section>
    <section class="content paddingleft_right15">
        <div id="info" style="display: none"></div>
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4 class="box-title">Laravel Generator Builder</h4>
            </div>
            <div class="panel-body">
                <form id="form">
                    <input type="hidden" name="_token" id="token" value="{!! csrf_token() !!}"/>
                    <div class="col-md-12">
                    <div class="form-group col-md-4">
                        <label for="txtModelName">Model Name<span class="required">*</span></label>
                        <input type="text" class="form-control text-capitalize" required name="model_name" id="txtModelName" placeholder="Enter name">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="drdCommandType">Command Type</label>
                        <select id="drdCommandType" class="form-control" style="width: 100%">
                            {{--<option value="infyom:api_scaffold">API Scaffold Generator</option>
                            <option value="infyom:api">API Generator</option>--}}
                            <option value="infyom:scaffold">Scaffold Generator</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="txtCustomTblName">Table Name</label> <i class="fa fa-info" data-toggle="tooltip" title="Following Laravel Table Convention"></i>
                        <input type="text" class="form-control" id="txtCustomTblName" placeholder="Enter table name">
                    </div>
                    </div>

                    <div class="form-group col-md-8">
                        <label for="txtModelName">Options</label>

                        <div class="form-inline form-group" style="border-color: transparent">
                            <div class="checkbox chk-align">
                                <label>
                                    <input type="checkbox" class="flat-red" id="chkDelete"><span
                                            class="chk-label-margin"> Soft Delete </span>
                                </label>
                            </div>
                            {{--<div class="checkbox chk-align">
                                <label>
                                    <input type="checkbox" class="flat-red" id="chkSave"> <span
                                            class="chk-label-margin">Save Schema</span>
                                </label>
                            </div>
                            <div class="checkbox chk-align" id="chSwag">
                                <label>
                                    <input type="checkbox" class="flat-red" id="chkSwagger"> <span
                                            class="chk-label-margin">Swagger</span>
                                </label>
                            </div>
                            <div class="checkbox chk-align" id="chTest">
                                <label>
                                    <input type="checkbox" class="flat-red" id="chkTestCases"> <span
                                            class="chk-label-margin">Test Cases</span>
                                </label>
                            </div>--}}
                            <div class="checkbox chk-align" id="chDataTable">
                                <label>
                                    <input type="checkbox" class="flat-red" id="chkDataTable"> <span
                                            class="chk-label-margin">Datatables</span>
                                </label>
                            </div>
                            <div class="checkbox chk-align" id="chMigrate">
                                <label>
                                    <input type="checkbox" class="flat-red" id="chkMigrate" checked> <span
                                            class="chk-label-margin">Migrate</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="txtPrefix">Prefix</label>
                        <input type="text" class="form-control" id="txtPrefix" placeholder="Enter prefix">
                    </div>

                    <div class="form-group col-md-1">
                        <label for="txtPaginate">Paginate</label>
                        <input type="number" class="form-control" value="10" id="txtPaginate" placeholder="">
                    </div>

                   {{-- <div class="form-group col-md-6">
                        <label for="leftMenuIcons">Icons</label>
                        <input type="text" name="icon_name" class="form-control" data-toggle="modal"
                               data-target="#iconsModal" id="leftMenuIcons" placeholder="Select your icon">
                    </div>--}}

                    <div class="col-md-12">
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            The Primary key <code>id</code> and timestamps <code>created_at</code> and <code>updated_at</code> will be created automatically!
                        </div>
                    </div>

                    <div class="table-responsive col-md-12">
                        <table class="table table-striped table-bordered" id="table">
                            <thead class="no-border">
                            <tr>
                                <th>Field Name</th>
                                <th>DB Type</th>
                                <th>Validations</th>
                                <th>Html Type</th>
                                <th style="width: 68px">Primary</th>
                                <th style="width: 87px">Searchable</th>
                                <th style="width: 63px">Fillable</th>
                                <th style="width: 65px">In Form</th>
                                <th style="width: 67px">In Index</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody id="container" class="no-border-x no-border-y ui-sortable">

                            </tbody>
                        </table>
                    </div>

                    <div class="form-inline col-md-12" style="padding-top: 10px">
                        <div class="form-group chk-align" style="border-color: transparent;">
                            <button type="button" class="btn btn-primary btn-flat" id="btnAdd"> Add Field
                            </button>
                        </div>
                    </div>

                    <div class="form-inline col-md-12 div_gnr_rst">
                        <div class="form-group btn_generate">
                            <button type="submit" class="btn btn-success btn-flat" id="btnGenerate">Generate
                            </button>
                        </div>
                        <div class="form-group btn_generate">
                            <button type="button" class="btn btn-default btn-flat" id="btnReset" data-toggle="modal"
                                    data-target="#confirm-delete"> Reset
                            </button>
                        </div>
                    </div>


                    <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog"
                         aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"
                                            aria-hidden="true">&times;</button>
                                    <h4 class="modal-title" id="myModalLabel">Confirm Reset</h4>
                                </div>

                                <div class="modal-body">
                                    <p style="font-size: 16px">This will reset all of your fields. Do you want to
                                        proceed?</p>

                                    <p class="debug-url"></p>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-flat btn-default" data-dismiss="modal">No
                                    </button>
                                    <a id="btnModelReset" class="btn btn-flat btn-danger btn-ok" data-dismiss="modal">Yes</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>

            </div>
        </div>

    </section>

    <div class="modal fade" id="iconsModal" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Select Icon</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-3 col-sm-4">
                            <i class="livicon" data-name="home" data-size="28" data-c="#418bca" data-hc="#418bca" ></i>
                        </div>
                        <div class="col-md-3 col-sm-4">
                            <i class="livicon" data-name="info" data-size="28" data-c="#418bca" data-hc="#418bca"></i>
                        </div>
                        <div class="col-md-3 col-sm-4 ">
                            <i class="livicon" data-name="trash" data-size="28" data-c="#418bca" data-hc="#418bca"></i>
                        </div>
                        <div class="col-md-3 col-sm-4 ">
                            <i class="livicon" data-name="edit" data-size="28" data-c="#418bca" data-hc="#418bca"></i>
                        </div>
                        <div class="col-md-3 col-sm-4 ">
                            <i class="livicon" data-name="dashboard" data-size="28" data-c="#418bca" data-hc="#418bca"></i>
                        </div>
                        <div class="col-md-3 col-sm-4 ">
                            <i class="livicon" data-name="desktop" data-size="28" data-c="#418bca" data-hc="#418bca"></i>
                        </div>
                        <div class="col-md-3 col-sm-4 ">
                            <i class="livicon" data-name="bell" data-size="28" data-c="#418bca" data-hc="#418bca"></i>
                        </div>
                        <div class="col-md-3 col-sm-4 ">
                            <i class="livicon" data-name="bank" data-size="28" data-c="#418bca" data-hc="#418bca"></i>
                        </div>
                        <div class="col-md-3 col-sm-4 ">
                            <i class="livicon" data-name="servers" data-size="28" data-c="#418bca" data-hc="#418bca"></i>
                        </div>
                        <div class="col-md-3 col-sm-4 ">
                            <i class="livicon" data-name="shield" data-size="28" data-c="#418bca" data-hc="#418bca"></i>
                        </div>
                        <div class="col-md-3 col-sm-4 ">
                            <i class="livicon" data-name="gear" data-size="28" data-c="#418bca" data-hc="#418bca"></i>
                        </div>
                        <div class="col-md-3 col-sm-4 ">
                            <i class="livicon" data-name="globe" data-size="28" data-c="#418bca" data-hc="#418bca"></i>
                        </div>
                        <div class="col-md-3 col-sm-4 ">
                            <i class="livicon" data-name="image" data-size="28" data-c="#418bca" data-hc="#418bca"></i>
                        </div>
                        <div class="col-md-3 col-sm-4 ">
                            <i class="livicon" data-name="users" data-size="28" data-c="#418bca" data-hc="#418bca"></i>
                        </div>
                        <div class="col-md-3 col-sm-4 ">
                            <i class="livicon" data-name="list" data-size="28" data-c="#418bca" data-hc="#418bca"></i>
                        </div>
                        <div class="col-md-3 col-sm-4 ">
                            <i class="livicon" data-name="thumbnails-big" data-size="28" data-c="#418bca" data-hc="#418bca"></i>
                        </div>
                        <div class="col-md-3 col-sm-4 ">
                            <i class="livicon" data-name="user" data-size="28" data-c="#418bca" data-hc="#418bca"></i>
                        </div>
                        <div class="col-md-3 col-sm-4 ">
                            <i class="livicon" data-name="wrench" data-size="28" data-c="#418bca" data-hc="#418bca"></i>
                        </div>
                        <div class="col-md-3 col-sm-4 ">
                            <i class="livicon" data-name="map" data-size="28" data-c="#418bca" data-hc="#418bca"></i>
                        </div>
                        <div class="col-md-3 col-sm-4 ">
                            <i class="livicon" data-name="paper-plane" data-size="28" data-c="#418bca" data-hc="#418bca"></i>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@stop
@section('footer_scripts')
    <script language="javascript" type="text/javascript" src="{{ asset('assets/vendors/select2/js/select2.js') }}"></script>
    <script language="javascript" type="text/javascript" src="{{ asset('assets/vendors/iCheck/js/icheck.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/sweetalert/js/sweetalert.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/sweetalert/js/sweetalert-dev.js') }}"></script>
    <script src="{{ asset('assets/vendors/bootstrapvalidator/js/bootstrapValidator.min.js') }}"
            type="text/javascript"></script>
    <script>

        $('.left-side').addClass('collapse-left');
        $('.right-side').addClass('strech');

        $(document).ready(function() {
            $('#form').bootstrapValidator({
                fields: {
                    model_name: {
                        validators: {
                            regexp: {
                                regexp: /^[a-zA-Z']*$/,
                                message: 'The modal name can consist of characters only'
                            }
                        }
                    }
                }
            });
        });
        $("select").select2({width: '100%'});
        var fieldIdArr = [];
        $(function () {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });

            $("#drdCommandType").on("change", function () {
                if ($(this).val() == "infyom:scaffold") {
                    $('#chSwag').hide();
                    $('#chTest').hide();
                }
                else {
                    $('#chSwag').show();
                    $('#chTest').show();
                }
            });

            $(document).ready(function () {
                var htmlStr = '<tr class="item" style="display: table-row;"></tr>';
                var commonComponent = $(htmlStr).filter("tr").load('{!! url('') !!}/admin/field_template');

                $("#btnAdd").on("click", function () {
                    var item = $(commonComponent).clone();
                    initializeCheckbox(item);
                    $("#container").append(item);
                });

                $("#btnTimeStamps").on("click", function () {
                    var item_created_at = $(commonComponent).clone();
                    $(item_created_at).find('.txtFieldName').val("created_at");
                    renderTimeStampData(item_created_at);
                    initializeCheckbox(item_created_at);
                    $("#container").append(item_created_at);


                    var item_updated_at = $(commonComponent).clone();
                    $(item_updated_at).find('.txtFieldName').val("updated_at");
                    renderTimeStampData(item_updated_at);
                    initializeCheckbox(item_updated_at);
                    $("#container").append(item_updated_at);
                });

                $("#btnPrimary").on("click", function () {
                    var item = $(commonComponent).clone();
                    renderPrimaryData(item);
                    initializeCheckbox(item);
                    $("#container").append(item);
                });

                $("#btnModelReset").on("click", function () {
                    $("#container").html("");
                    $('input:text').val("");
                    $('input:checkbox').iCheck('uncheck');

                });

                function capitalizeFirstLetter(string) {
                    return string.charAt(0).toUpperCase() + string.slice(1);
                }

                $("#form").on("submit", function () {
                    var fieldArr = [];
                    var validationArray,validationString;
                    $('.item').each(function () {

                        var htmlType = $(this).find('.drdHtmlType');
                        var htmlValue = "";
                        if ($(htmlType).val() == "select" || $(htmlType).val() == "radio") {
                            htmlValue = $(this).find('.drdHtmlType').val() + ':' + $(this).find('.txtHtmlValue').val();
                        }
                        else {
                            htmlValue = $(this).find('.drdHtmlType').val();
                        }
                        validationArray = $(this).find('.txtValidation').val();

                        if(validationArray==null){
                            validationString = '';
                        }
                        else
                            validationString = validationArray.join('|');

                        fieldArr.push({
                            fieldInput: $(this).find('.txtFieldName').val() + ':' + $(this).find('.txtdbType').val(),
                            htmlType: htmlValue,
                            validations: validationString,
                            searchable: $(this).find('.chkSearchable').prop('checked'),
                            fillable: $(this).find('.chkFillable').prop('checked'),
                            primary: $(this).find('.chkPrimary').prop('checked'),
                            inForm: $(this).find('.chkInForm').prop('checked'),
                            inIndex: $(this).find('.chkInIndex').prop('checked')
                        });
                    });

                    fieldArr.unshift({
                        fieldInput:'id:increments',
                        htmlType : validationString,
                        validations:false,
                        searchable:false,
                        fillable: false,
                        primary:true,
                        inForm:false,
                        inIndex:false
                    });

                    var data = {
                        modelName: capitalizeFirstLetter($('#txtModelName').val()),
                        commandType: $('#drdCommandType').val(),
                        tableName: $('#txtCustomTblName').val(),
                        iconName: $('#leftMenuIcons').val(),
                        prefix: $('#txtPrefix').val(),
                        paginate: $('#txtPaginate').val(),
                        migrate: $('#chkMigrate').prop('checked'),
                        options: {
                            softDelete: $('#chkDelete').prop('checked'),
                            save: $('#chkSave').prop('checked'),
                            swagger: $('#chkSwagger').prop('checked'),
                            tests: $('#chkTestCases').prop('checked'),
                            datatables: $('#chkDataTable').prop('checked')
                        },
                        fields: fieldArr
                    };

                    console.log(data);
                    data['_token'] = $('#token').val();

                    $.ajax({
                        url: '{!! url('') !!}/admin/generator_builder/generate',
                        type: "POST",
                        dataType: 'json',
                        contentType: 'application/json',
                        data: JSON.stringify(data),
                        success: function (result) {
//                            swal('success',result,"success");
                            swal({title:'success',text: result, type: "success",closeOnConfirm: false,showLoaderOnConfirm: true},
                              function(){
                                  setTimeout(function(){location.reload();}, 1500);

                              });
                        },
                        error: function (result) {

                            swal('error',result,'failed');
                        }
                    });

                    return false;
                });

                function renderPrimaryData(el) {

                    $('.chkPrimary').iCheck(getiCheckSelection(false));

                    $(el).find('.txtFieldName').val("id");
                    $(el).find('.txtdbType').val("increments");
                    $(el).find('.chkSearchable').attr('checked', false);
                    $(el).find('.chkFillable').attr('checked', false);
                    $(el).find('.chkPrimary').attr('checked', true);
                    $(el).find('.chkInForm').attr('checked', false);
                    $(el).find('.chkInIndex').attr('checked', false);
                }

                function renderTimeStampData(el) {
                    $(el).find('.txtdbType').val("timestamp");
                    $(el).find('.chkSearchable').attr('checked', false);
                    $(el).find('.chkFillable').attr('checked', false);
                    $(el).find('.chkPrimary').attr('checked', false);
                    $(el).find('.chkInForm').attr('checked', false);
                    $(el).find('.chkInIndex').attr('checked', false);
                    $(el).find('.drdHtmlType').val('date').trigger('change');
                }

            });

            function initializeCheckbox(el) {
                $(el).find('input:checkbox').iCheck({
                    checkboxClass: 'icheckbox_square-blue',
                    radioClass: 'iradio_square-blue'
                });
                $(el).find("select").select2({width: '100%'});

                $(el).find(".chkPrimary").on("ifClicked", function () {
                    $('.chkPrimary').each(function () {
                        $(this).iCheck('uncheck');
                    });
                });

                $(el).find(".chkPrimary").on("ifChanged", function () {
                    if ($(this).prop('checked') == true) {
                        $(el).find(".chkSearchable").iCheck('uncheck');
                        $(el).find(".chkFillable").iCheck('uncheck');
                        $(el).find(".chkInForm").iCheck('uncheck');
                    }
                });

                var htmlType = $(el).find('.drdHtmlType');

                $(htmlType).select2().on('change', function () {
                    if ($(htmlType).val() == "select" || $(htmlType).val() == "radio")
                        $(el).find('.htmlValue').show();
                    else
                        $(el).find('.htmlValue').hide();
                });

            }

        });

        function getiCheckSelection(value) {
            if (value == true)
                return 'checked';
            else
                return 'uncheck';
        }

        function removeItem(e) {
            e.parentNode.parentNode.parentNode.removeChild(e.parentNode.parentNode);
        }

        $('#txtModelName').keyup(function(){
            var modalName=$('#txtModelName').val();
            var tableName=modalName.concat('s');
            $('#txtCustomTblName').val(tableName);
            $('#txtCustomTblName').css('text-transform','lowercase');
            if(modalName==''){
                $('#txtCustomTblName').val('');
            }
        });
        $('.livicon').on('click',function(){
            var icon_name=$(this).attr('data-name');
            $('#leftMenuIcons').val(icon_name);
            $('.close').click();
        });

    </script>
@stop