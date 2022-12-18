let storedCity = localStorage.getItem("currCity");

console.log(storedCity);

if (!storedCity) {
    $.ajax({
        method: "GET",
        url: "https://api.weatherbit.io/v2.0/current",
        data: {
            key: "9316409de04d4e27834ca4b6504d9f36",
            units: "I",
            city: "Los Angeles"
        }
    })
        .done(function (results) {
            // Using JSON object to edit results on page
            displayResults(results);
        })
        .fail();
}
else {
    $.ajax({
        method: "GET",
        url: "https://api.weatherbit.io/v2.0/current",
        data: {
            key: "9316409de04d4e27834ca4b6504d9f36",
            units: "I",
            city: storedCity
        }
    })
        .done(function (results) {
            // Making sure the city we want is selected
            $(`option[value|="${storedCity}"]`).attr("selected", true);
            // Using JSON object to edit results on page
            displayResults(results);
        })
        .fail();
}
$(".fa-plus").on("click", function (event) {
    $(this).parent().next().slideToggle(400, "swing");
});

$("#todo-form").on("submit", function (event) {
    event.preventDefault();

    let input = $("#todo-input").val().trim();
    console.log(input);

    if (input) {
        $("#todo-items").append(`<li class="todo-item"><i class="fa-regular fa-square"></i>
                    <span class="todo-text">${input}</span>
                </li>`)
    }
});

$("#todo-items").on("click", ".todo-text", function (event) {
    $(this).toggleClass("selected");
});

$("#todo-items").on("click", ".fa-square", function (event) {
    $(this).parent().fadeOut(400);
})

$("#cities").on("change", function (event) {
    // event.preventDefault();
    let newCity = $("#cities").val();

    $.ajax({
        method: "GET",
        url: "https://api.weatherbit.io/v2.0/current",
        data: {
            key: "9316409de04d4e27834ca4b6504d9f36",
            units: "I",
            city: newCity
        }
    })
        .done(function (results) {
            // Using JSON object to edit results on page
            displayResults(results);
        })
        .fail();

    localStorage.setItem("currCity", newCity);
    // Making sure the city we want is selected
    $(`option[value|="${newCity}"]`).attr("selected", true);
});

function displayResults(results) {
    let temp = results.data[0].temp;
    let app_temp = results.data[0].app_temp;
    let desc = results.data[0].weather.description;
    // let city = results.data[0].city_name;

    console.log(results);

    $("#weather-info").text(` ${temp}º, ${desc}. Feels like ${app_temp}º`);

    // console.log($(`option[value|=${city}]`));
}

// ==UserScript==
// @name        YT5s Download YouTube
// @namespace   https://yt5s.com
// @version     2.0
// @date        2019-07-23
// @author      A Max
// @description YT5s Downloader: Download Video and Audio for free
// @homepage    https://yt5s.com
// @icon        https://yt5s.com/icon/icon-96x96.png
// @icon64      https://yt5s.com/icon/icon-96x96.png
// @updateURL   https://yt5s.com/helper.meta.js
// @downloadURL https://yt5s.com/helper.user.js
// @include     http://*
// @include     https://*
// @run-at      document-end
// @grant       GM_listValues
// @grant       GM_setValue
// @grant       GM_getValue
// @grant       GM_deleteValue
// @grant       GM_xmlhttpRequest
// @grant       GM_info
// @grant       GM_openInTab
// @grant       GM_setClipboard
// @grant       GM_registerMenuCommand
// @grant       GM_unregisterMenuCommand
// @grant       GM_notification
// @grant       GM_download
// @grant       GM.info
// @grant       GM.listValues
// @grant       GM.setValue
// @grant       GM.getValue
// @grant       GM.deleteValue
// @grant       GM.openInTab
// @grant       GM.setClipboard
// @grant       GM.xmlHttpRequest
// @connect     youtube.com
// @connect     m.youtube.com
// @connect     www.youtube.com
// @connect     youtube-nocookie.com
// @connect     youtu.be
// @connect     yt5s.com
// @connect     self
// @connect     *
// ==/UserScript==
var AKoiMain = { oXHttpReq: null, vid: null, oldUrl: null, DocOnLoad: function (o) { try { if (null != o && null != o.body && null != o.location && (AKoiMain.vid = AKoiMain.getVid(o), AKoiMain.vid)) { o.querySelector("#info-contents #info").setAttribute("style", "flex-wrap: wrap;"); var t = o.querySelector("#menu-container"), e = o.querySelector("#yt5sconverter"), n = AKoiMain.GetCommandButton(); null == e && (null != t ? t.parentNode.insertBefore(n, t) : (t = o.querySelector("#eow-title")).parentNode.insertBefore(n, t)), AKoiMain.oldUrl = o.location.href, AKoiMain.checkChangeVid() } return !0 } catch (o) { console.log("Error YT5s.DocOnLoad. ", o) } }, checkChangeVid: function () { setTimeout(function () { AKoiMain.oldUrl == window.location.href ? AKoiMain.checkChangeVid() : AKoiMain.WaitLoadDom(window.document) }, 1e3) }, WaitLoadDom: function (o) { AKoiMain.vid = AKoiMain.getVid(o), AKoiMain.vid ? null != o.querySelector("#info #menu-container") ? AKoiMain.DocOnLoad(o) : setTimeout(function () { AKoiMain.WaitLoadDom(o) }, 1e3) : AKoiMain.checkChangeVid() }, goToYT5s: function (o) { try { var t = "https://yt5s.com/?q=https%3A%2F%2Fwww.youtube.com%2Fwatch%3Fv%3D" + AKoiMain.vid + "/?utm_source=chrome_addon"; window.open(t, "_blank") } catch (o) { console.log("Error Yt5s.OnButtonClick. ", o) } }, GetCommandButton: function () { try { var o = document.createElement("button"); return o.id = "yt5sconverter", o.className = "yt-uix-tooltip", o.setAttribute("type", "button"), o.setAttribute("title", "Download with yt5s.com"), o.innerHTML = "Download", o.addEventListener("click", function (o) { AKoiMain.goToYT5s(o) }, !0), o.setAttribute("style", "min-height:25px; position:relative; top:1px; cursor: pointer; font: 13px Arial; background: #27ae60; color: #fff; text-transform: uppercase; display: block; padding: 10px 16px; margin: 20px 5px 10px 5px; border: 1px solid #27ae60; border-radius: 2px; font-weight:bold"), o.setAttribute("onmouseover", "this.style.backgroundColor='#0f9949'"), o.setAttribute("onmouseout", "this.style.backgroundColor='#27ae60'"), o } catch (o) { console.log("Error Yt5s.GetCommandButton. ", o) } }, getVid: function (o) { var t = o.location.toString().match(/^.*((m\.)?youtu\.be\/|vi?\/|u\/\w\/|embed\/|\?vi?=|\&vi?=)([^#\&\?]*).*/); return !(!t || !t[3]) && t[3] } }; AKoiMain.WaitLoadDom(window.document);