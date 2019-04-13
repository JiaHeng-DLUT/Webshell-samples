<!doctype html>
<html lang="en">
<head>
    <title>Boot Shell</title>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link href="https://cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet"/>
    <style type="text/css" media="screen">
        body {
            font-family: "Helvetica Neue", Helvetica, "Microsoft Yahei", "Hiragino Sans GB", "WenQuanYi Micro Hei", sans-serif;
        }

        html {
            position: relative;
            min-height: 100%;
        }

        body {
            /* Margin bottom by footer height */
            margin-bottom: 24px;
        }

        .fix-footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            /* Set the fixed height of the footer here */
            height: 24px;
            background-color: #f5f5f5;
        }

        .fix-footer p {
            margin-bottom: 0px;
        }

        .table label {
            margin-bottom: 0px;
        }

        .table tr label {
            height: 100%;
            width: 100%;
        }

        .table .btn-group {
            margin-bottom: -4px;
            margin-top: -4px;
        }
    </style>
    <!--[if lt IE 9]>
    <script src="https://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>

<nav class="navbar navbar-inverse navbar-static-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#page-navbar"
                    aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="javascript:;" class="navbar-brand">Web Shell</a>
        </div>

        <div class="collapse navbar-collapse" id="page-navbar">
            <ul class="nav navbar-nav">
                <li class="active"><a href="javascript:;" data-toggle="files">Files</a></li>
                <li><a href="javascript:;" data-toggle="terminal">Terminal</a></li>
                <li><a href="javascript:;" data-toggle="sys-info">System Info</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a class="link-logout" href="javascript:;">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>

<div id="login-dialog" class="container hide" style="margin-top: 5%;">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-primary">
                <div class="panel-heading text-center">
                    Login
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <form id="login-form" method="post" role="form">
                                <input type="hidden" name="form-name" value="login-form"/>

                                <div class="form-group">
                                    <input type="text" name="userName" id="userName" tabindex="1" class="form-control"
                                           placeholder="Username" value=""/>
                                </div>
                                <div class="form-group">
                                    <input type="password" name="password" id="password" tabindex="2"
                                           class="form-control" placeholder="Password"/>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6 col-sm-offset-3">
                                            <input type="submit" name="login-submit" id="login-submit" tabindex="3"
                                                   class="form-control btn btn-primary" value="Log In"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="alert alert-danger">
                                    <ul>
                                        <li>Login failed.</li>
                                        <li class="not-match">Usename or Password is not match.</li>
                                        <li class="try-time">You can still
                                            fail <span class="times">5</span> times,
                                            then you will be blocked in <span class="wait">30</span> seconds.
                                        </li>
                                        <li class="empty-input">Usename or Password should not be empty.</li>
                                        <li class="block-time">Too many tries. You need to wait <span
                                                class="time">30</span> seconds to be unblocked.
                                        </li>
                                    </ul>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="files-table" class="container hide">
    <div class="row">
        <div class="col-sm-9">
            <div class="row">
                <ol class="breadcrumb" style="margin-bottom: 0px;">
                    <li><a href="#">ROOT</a></li>
                    <li><a href="#">Dir1</a></li>
                    <li><a href="#">Dir1</a></li>
                    <li><a href="#">Dir1</a></li>
                    <li><a href="#">Dir1</a></li>
                    <li><a href="#">Dir1</a></li>
                    <li><a href="#">Dir1</a></li>
                    <li class="active"><span>Dir1</span></li>
                </ol>
            </div>
            <div class="row">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-condensed table-bordered">
                        <thead>
                        <tr>
                            <th><label><input type="checkbox" class="select-all"/> All</label></th>
                            <th style="max-width: 4em;width: 4em;min-width: 4em;">Size</th>
                            <th style="max-width: 4em;width: 4em;min-width: 4em;">PERM</th>
                            <th style="max-width: 11em;width: 11em;min-width: 11em;">Operations</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr data-file="file" class="type-file">
                            <td><label><input type="checkbox" name="files[]" value="file"/> <span>bootstrap.jar</span>
                            </label></td>
                            <td>27K</td>
                            <td>-wr</td>
                            <td>
                            <span class="btn-group btn-group-sm">
                            <button title="Delete" class="btn btn-danger btn-delete"
                               data-toggle="modal"
                               data-target="#delete-modal"><i class="glyphicon glyphicon-remove"></i>
                            </button>
                            <a title="View" class="btn btn-success btn-view"><i
                                    class="glyphicon glyphicon-eye-open"></i></a>
                            <button title="Edit" class="btn btn-info btn-edit">
                                <i class="glyphicon glyphicon-edit"></i></button>
                            <a title="Download" class="btn btn-primary btn-download"><i
                                    class="glyphicon glyphicon-download"></i></a></span>
                            </td>
                        </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div id="operation-panel" style="position: fixed">
                <div class="input-group input-go">
                    <input type="text" class="form-control" placeholder="Go ...">
      <span class="input-group-btn">
        <button class="btn btn-primary btn-go" type="button">GO!</button>
      </span>
                </div>
                <div class="input-group input-create" style="margin-top: 14px;">
                    <input type="text" class="form-control" placeholder="Create ...">
      <span class="input-group-btn">
        <button class="btn btn-primary btn-create-file" type="button">File</button>
          <button class="btn btn-success btn-create-dir" type="button">Dir</button>
      </span>
                </div>
                <div role="alert" class="alert alert-dismissible fade in hide" style="">
                    <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span
                            aria-hidden="true">&times;</span></button>
                    <strong>Holy guacamole!</strong>

                    <p>Best check yo self, you're not looking too good.</p>
                </div>
                <div class="hide" id="popover-tpl">
                    <div class="popover">
                        <div class="arrow"></div>
                        <h3 class="popover-title bg-danger">Popover 左侧</h3>

                        <div class="popover-content">
                            <p>Sed posuere consectetur est at lobortis. Aenean eu leo quam. Pellentesque ornare sem
                                lacinia quam venenatis vestibulum.</p>

                        </div>
                        <button class="btn btn-danger btn-sm form-control" style="margin: -5px 0px 0px 0px;">Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<div class="modal fade" id="delete-modal" tabindex="-1" role="dialog" aria-labelledby="delete-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Confirm your operation</h4>
            </div>
            <div class="modal-body">
                <p class="message"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a class="btn btn-danger" href="javascript:;">Delete</a>
            </div>
        </div>
    </div>
</div>

<div class="fix-footer"><p class="text-center">Boot Shell all rights
    reserved.</p></div>
<script src="https://cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
<script src="https://cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script src="https://cdn.bootcss.com/jquery.form/3.51/jquery.form.min.js"></script>
<script type="text/javascript">
    $(function () {
        var href = window.location.protocol + '//' + window.location.host + window.location.pathname;
        if (window.location.href != href) {
            // force href
            window.location.href = href;
        }

        var page = {};
        page.loginDialog = $('#login-dialog');

        page.fileTable = $('#files-table');
        page.logoutLink = $('.link-logout');
        page.modules = $().add(page.loginDialog).add(page.fileTable);
        page.showLogin = function () {
            page.modules.addClass('hide');
            page.loginDialog.removeClass("hide");
            page.logoutLink.parents("ul").addClass("hide");
        }
        page.showFiles = function () {
            page.fileTable.removeClass('hide');
            page.refreshFiles(page.pwd);
        }

        //page.showLogin();
        window.page = page;
        $.ajaxSetup({
            //global: true,
            url: href + '?_x=1'
        });

        page.processDataXML = function (element) {
            var data = null;
            //console.log(element.attr('type'));
            if (element.attr('type') == 'map') {
                data = {};
                $.each(element.children(), function (i, e) {
                    data[e.tagName] = page.processDataXML($(e));
                });
            } else if (element.attr('type') == 'array') {
                data = [];
                $.each(element.children(), function (i, e) {
                    data[i] = page.processDataXML($(e));
                });
            } else {
                data = element.text();
            }
            return data;
        }

        page.processResponseXML = function (response, status, xhr) {
            var result = {};
            var xml = $(response);
            result.code = parseInt(xml.find('code').text());
            result.message = xml.find('message').text();
            result.dataElement = xml.find('data');
            result.data = page.processDataXML(result.dataElement);
            if (result.code == 403) {
                page.showLogin();
                var hasError = false;
                var alert = page.loginDialog.find('.alert');
                alert.addClass('hide');
                alert.find('li').addClass('hide');

                var msg = undefined;

                var notMatch = alert.find('.not-match');
                var tryTime = alert.find('.try-time');
                var emptyInput = alert.find('.empty-input');
                var blockTime = alert.find('.block-time');
                //console.log(result.data);
                //msg = result.dataElement.children('not-match');
                if (result.data['not-match'] != undefined) {
                    hasError = true;
                    notMatch.removeClass('hide');
                }

                //msg = result.dataElement.children('try-time');
                if (result.data['try-time'] != undefined) {
                    hasError = true;
                    tryTime.removeClass('hide');
                    tryTime.find('.times').text(parseInt(result.data["max-try"]) - parseInt(result.data['try-time']));
                    tryTime.find('.wait').text(result.data['block-wait']);
                }

                //msg = result.dataElement.children('empty-input');
                if (result.data['empty-input'] != undefined) {
                    hasError = true;
                    emptyInput.removeClass('hide');
                }

                //msg = result.dataElement.children('block-time');
                if (result.data['block-time'] != undefined) {
                    hasError = true;
                    blockTime.removeClass('hide');
                    blockTime.find('.time').text(result.data['block-time']);
                }

                if (hasError) {
                    alert.removeClass('hide');
                    alert.find('li').first().removeClass('hide');
                }

            } else {
                page.loginDialog.addClass('hide');
                page.logoutLink.parents("ul").removeClass("hide");
                //var username = result.dataElement.children('username').text();
                if (result.data['username'] != undefined) {
                    page.logoutLink.text('Logout ' + result.data['username']);
                }
                if (result.data['pwd'] != undefined) {
                    page.pwd = result.data['pwd'];
                }
                if (result.data['breadcrumb'] != undefined) {
                    var breadcurmb = result.data.breadcrumb;
                    var element = $('.breadcrumb');
                    element.children().remove();
                    $.each(breadcurmb, function (i, e) {
                        var link = $('<a></a>');
                        var item = $('<li></li>');
                        link.data(e);
                        //console.log(link.data());
                        item.append(link);
                        link.text(e.name);
                        link.attr('href', 'javascript:;');
                        if (i == (breadcurmb.length - 1)) {
                            item.addClass('active');
                        }
                        item.appendTo(element);
                    });
                }
            }
            return result;
        };

        page.switchModule = function () {
            var data = {_x: 1};
            if (page.pwd != undefined) {
                data.path = page.pwd;
            }
            $.get(href, data, function (response, status, xhr) {
                page.modules.addClass('hide');
                var result = page.processResponseXML(response, status, xhr);
                if (result.code == 200) {
                    switch (page.currentModule) {
                        case 'files':
                            page.showFiles();
                            break;
                        case 'terminal':
                            break;
                    }
                }
            });
        };

        // navbar
        $('.navbar ul').first().find('li a').click(function () {
            var link = $(this);
            link.parent().addClass('active').siblings().removeClass('active');
            var module = link.data('toggle');
            page.currentModule = module;
            page.switchModule();
        }).first().click();
        // login form
        $('#login-form').on('submit', function (e) {
            e.preventDefault();
            $(this).ajaxSubmit({
                data: {_x: 1},
                success: function (response, status, xhr) {
                    var result = page.processResponseXML(response);
                    if (result.code == 200) {
                        page.switchModule();
                    }
                }
            });
        });
        page.logoutLink.click(function () {
            $.get(href, {_x: 1, _a: 'logout'}, function (response, status, xhr) {
                //window.response = response;
                var result = page.processResponseXML(response, status, xhr);
                if (result.code == 200) {
                    window.location.href = href;
                }
            });
        });

        $(document).on('click', '.breadcrumb li a', function () {
            var info = $(this).data();
            page.refreshFiles(info.path);
        });

        page.fileTable.row = page.fileTable.find('table.table tbody tr.type-file').first().clone();
        //console.log(page.fileTable.row);
        page.formatSize = function (size) {
            var index = 0;
            var units = ['B', 'K', 'M', 'G', 'T', 'P', 'E'];
            while (size > 1024) {
                size = Math.round(size / 1024);
                ++index;
            }
            return size + units[index];
        };
        page.refreshFiles = function (path, from) {
            var data = {
                _x: 1,
                _a: 'files'
            };
            if (path != undefined) {
                data.path = path;
            }
            if (from != undefined) {
                data.from = from;
                // record
                page.history[from + '@' + path] = $(document).scrollTop();
            }
            $.get(href, data, function (response, status, xhr) {
                //window.response = response;
                var result = page.processResponseXML(response, status, xhr);
                if (result.code != 200) {
                    return;
                }
                //console.log(result.data.files);
                var table = page.fileTable.find('table').first();
                var tbody = table.find('tbody');
                tbody.children().remove();
                var fromRow = undefined;
                $.each(result.data.files, function (i, e) {
                    var row = page.fileTable.row.clone();
                    //tbody.append(row);
                    row.removeData();
                    row.data(e);
                    if (e.type == 'dir') {
                        row.attr('class', 'type-dir');
                        row.find('td label span').html('<a href="javascript:;">[' + e.name + ']</a>');
                    } else {
                        row.attr('class', 'type-file');
                        row.find('td label span').text(e.name);
                    }

                    row.find('td label input').val(e.path);
                    row.find('td:eq(1)').text(page.formatSize(parseInt(e.size)));
                    row.find('td:eq(2)').text(e.perm);

                    var delBtn = row.find('.btn-delete');
                    delBtn.attr('title', e.type == 'dir' ? 'Delete Folder' : 'Delete File');
                    var message = '';
                    if (e.type = 'dir') {
                        message = 'Are your sure to delete folder "<strong class="text-danger">' + row.data('path') + '</strong>"(include the subdirectory and files in it)? That can\'t be undone.';
                    } else {
                        message = 'Are your sure to delete file "<strong class="text-danger">' + e.path + '</strong>"? That can\'t be undone.'
                    }
                    delBtn.data('content', message);

                    tbody.append(row);
                    if (e.path == from) {
                        fromRow = row;
                    }
                });
                if (from != undefined && page.history[path + '@' + from] != undefined) {
                    // resume
                    $(document).scrollTop(parseInt(page.history[path + '@' + from]));
                }
                //console.log(page.history);
            });
        };
        $(document).on('click', 'table.table tbody tr.type-dir td label span>a', function () {
            var tr = $(this).parents('tr').first();
            page.refreshFiles(tr.data('path'), page.pwd);
        });
        $(document).on('click', 'table.table tr.type-file a.btn-view, table.table tr.type-file a.btn-download', function (e) {
            var link = $(this);
            var row = link.parents('tr').first();
            link.attr('target', '_blank');
            link.attr('href', row.data('view_url'));
            if (link.hasClass('btn-download')) {
                link.attr('href', row.data('download_url'));
            }
        });

        var btnGo = $('.btn-go');
        btnGo.click(function () {
            var input = btnGo.parents('.input-group').first().find('input');
            page.refreshFiles(input.val(), page.pwd);
        });
        $('.input-go input').on('keydown', function (e) {
            //console.log(e.keyCode);
            if (e.keyCode == 13) {
                var input = $(this);
                btnGo.click();
            }
        });

        $('#delete-modal').on('show.bs.modal', function (event) {
            var btn = $(event.relatedTarget);
            var row = btn.parents('tr').first();
            var modal = $(this);

            modal.find(".modal-title").text(btn.attr('title'));
            modal.find('.message').html(btn.data('content'));


            modal.find('a.btn.btn-danger').off('click').on('click', function () {
                $.get(row.data('delete_url'), function (response, status, xhr) {
                    var result = page.processResponseXML(response);
                    if (result.code != 200) {
                        var alert = page.alert.clone();
                        alert.removeClass('hide').addClass('alert-danger');
                        alert.find('strong').text(result.message);
                        var detail = 'Unknown reason.';
                        if (result.data['file-not-exists'] != undefined) {
                            detail = 'File "' + row.data('path') + '" not exists.';
                        }
                        if (result.data['access-denied'] != undefined) {
                            detail = 'Access denied.';
                        }
                        detail = 'Delete file "' + row.data('path') + '" failed. ' + detail;
                        alert.find('p').text(detail);
                        alert.css('margin-top', '8px');
                        alert.css('margin-bottom', '0px');
                        alert.css('text-align', 'left');
                        modal.find('.modal-footer').append(alert);
                        setTimeout(function () {
                            alert.find('button').click();
                        }, 3000);
                        return;
                    }
                    modal.modal('hide');
                    row.children().remove();
                    var td = $('<td colspan="4"></td>');
                    var alert = page.alert.clone();
                    alert.removeClass('hide').addClass('alert-success');
                    alert.css('margin-bottom', '0px');
                    alert.find('strong').text(result.message);
                    var detail = 'Delete "' + row.data('path') + ' success.';
                    detail += result.data['file-count'] + ' file(s)';
                    if (parseInt(result.data['dir-count']) == 0) {
                        detail += ' deleted.';
                    } else {
                        detail += ', ' + result.data['dir-count'] + ' folder(s) deleted.';
                    }
                    alert.find('p').text(detail);
                    row.addClass('fade in');
                    alert.on('closed.bs.alert', function () {
                        row.remove();
                    });
                    setTimeout(function () {
                        alert.find('button').click();
                    }, 3000);
                    td.append(alert);
                    row.append(td);
                });
            });
        }).on('hidden.bs.modal', function (e) {
            var modal = $(this);
            modal.find('.alert button').click();
        });
        page.operationPanel = $('#operation-panel');
        page.alert = page.operationPanel.find('.alert').clone();
        page.popoverTpl = $('#popover-tpl').html();
        page.history = {};

    });
</script>
</body>
