/*
 * This file is part of the Vistar project.
 * This source code under MIT license
 *
 * Copyright (c) 2017 Vistar project <https://github.com/vistarsvo/>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 *
 */

var defaultAjaxSelectorForLinks = 'a.for-ajax, ul.for-ajax a';
$(document).ready(function(){
    setAjaxLoadLinks(defaultAjaxSelectorForLinks);
});

/**
 * This function set onClick listener to load data via jQuery ajax into container
 * All data- attributes wil be sending by POST method
 * In parent container will be appended loader DIVs
 * @param selectorForLinks
 */
function setAjaxLoadLinks(selectorForLinks) {
    $(selectorForLinks).unbind('click');
    $(selectorForLinks).on('click', function (event) {
        var curObj = $(this);
        var allData = curObj.data();
        var container;
        if (allData.modal) {
            var modal = $(allData.modal);
            if (allData.modalheader) {
                $('.modal-header span.title', modal).html(allData.modalheader);
            } else {
                $('.modal-header span.title', modal).html('');
            }
            if (allData.modalfooter) {
                $('.modal-footer', modal).html(allData.modalfooter);
            } else {
                $('.modal-footer', modal).html('');
            }
            container = $(curObj.data('container'), modal);
            modal.modal('show');
        } else {
            container = $(curObj.data('container'));
        }

        if (allData.search) {
            var formdata = $(allData.search + ' :input').serializeArray();
            $(formdata).each(function(index, obj){
                allData[obj.name] = obj.value;
            });
            //allData.search = null;
            delete allData['search'];
        }


        var url = curObj.attr('href');


        var loader = '<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div><div class="loading-img"></div>';

        $(container).html("Loading...");
        container.parent().append(loader);
        curObj.hide();

        $.ajax({
            type: "POST",
            url: url,
            dataType: "HTML",
            data: allData
        }).success(function (html) {
            $(container).html(html);
            curObj.show();
            container.parent().find('.overlay').remove();
            container.parent().find('.loading-img').remove();
            setAjaxLoadLinks(selectorForLinks);
            if (allData.callback) {
                allData.callback();
            }
        }).error(function (xhr, status, error) {
            $(container).html("<b>Error:</b><br>");
            $(container).append(error + "<hr>");
            $(container).append('<b>Details:</b><br>');
            $(container).append(xhr.status + '<br>');
            $(container).append(xhr.responseText);
            curObj.show();
            container.parent().find('.overlay').remove();
            container.parent().find('.loading-img').remove();
            if (allData.callback) {
                allData.callback();
            }
        });

        event.preventDefault();
    });
}

/**
 * Load data via ajax request into container
 * @param allData
 * @param url
 * @param containerSelector
 */
function openWithAjax(allData, url, containerSelector) {
    var container = $(containerSelector);
    var loader = '<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div><div class="loading-img"></div>';
    container.parent().append(loader);
    $(container).html("Loading...");
    $.ajax({
        type: "POST",
        url: url,
        dataType: "HTML",
        data: allData
    }).success(function (html) {
        $(container).html(html);
        container.parent().find('.overlay').remove();
        container.parent().find('.loading-img').remove();
        setAjaxLoadLinks(defaultAjaxSelectorForLinks);
        if (allData.callback) {
            allData.callback;
        }
    }).error(function (xhr, status, error) {
        $(container).html("<b>Error:</b><br>");
        $(container).append(error + "<hr>");
        $(container).append('<b>Details:</b><br>');
        $(container).append(xhr.status + '<br>');
        $(container).append(xhr.responseText);
        container.parent().find('.overlay').remove();
        container.parent().find('.loading-img').remove();
        if (allData.callback) {
            allData.callback;
        }
    });
}

var allIds = [];

function CheckAll() {
    $(".proxyId").each(function () {
       allIds.push($(this).text());
    });
    if (allIds[0]) {
        goCheck(allIds[0], 0);
    }
}

function goCheck(elementId, num) {
    var url = '/index.php?r=proxymanager/proxies/check&id=' + elementId;
    num++;
    if (allIds[num]) {
        var cbId = allIds[num];
        allData = {callback:setTimeout(function() {goCheck(cbId, num)}, 500)};
    } else {
        allData = {};
    }
    openWithAjax(allData, url, '#proxy_' + elementId);
}
