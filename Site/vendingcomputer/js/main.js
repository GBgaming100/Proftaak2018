var oldQr = 0;

(function(undefined) {
    "use strict";

    function Q(el) {
        if (typeof el === "string") {
            var els = document.querySelectorAll(el);
            return typeof els === "undefined" ? undefined : els.length > 1 ? els : els[0];
        }
        return el;
    }
    var txt = "innerText" in HTMLElement.prototype ? "innerText" : "textContent";
    var scannerLaser = Q(".scanner-laser"),
        imageUrl = new Q("#image-url"),
        // play = Q("#play"),
        scannedImg = Q("#scanned-img"),
        scannedQR = Q("#scanned-QR"),
        grabImg = Q("#grab-img"),
        decodeLocal = Q("#decode-img");
    var args = {
        autoBrightnessValue: 100,
        resultFunction: function(res) {
            [].forEach.call(scannerLaser, function(el) {
                fadeOut(el, 0.5);
                setTimeout(function() {
                    fadeIn(el, 0.5);
                }, 300);
            });
            scannedImg.src = res.imgData;
            scannedQR[txt] = res.format + ": " + res.code;

            vendingdata(res.code);
        },
        getDevicesError: function(error) {
            var p, message = "Error detected with the following parameters:\n";
            for (p in error) {
                message += p + ": " + error[p] + "\n";
            }
            alert(message);
        },
        getUserMediaError: function(error) {
            var p, message = "Error detected with the following parameters:\n";
            for (p in error) {
                message += p + ": " + error[p] + "\n";
            }
            alert(message);
        },
        cameraError: function(error) {
            console.log("Camera doesn't work!")
        },
        cameraSuccess: function() {
            grabImg.classList.remove("disabled");
        }
    };
    var decoder = new WebCodeCamJS("#webcodecam-canvas").buildSelectMenu("#camera-select", "environment|back").init(args);
    decodeLocal.addEventListener("click", function() {
        Page.decodeLocalImage();
    }, false);
    $(document).ready(function() {
        if (!decoder.isInitialized()) {
            scannedQR[txt] = "Scanning ...";
        } else {
            scannedQR[txt] = "Scanning ...";
            decoder.play();
        }
    });
    grabImg.addEventListener("click", function() {
        if (!decoder.isInitialized()) {
            return;
        }
        var src = decoder.getLastImageSrc();
        scannedImg.setAttribute("src", src);
    }, false);

    function fadeOut(el, v) {
        el.style.opacity = 1;
        (function fade() {
            if ((el.style.opacity -= 0.1) < v) {
                el.style.display = "none";
                el.classList.add("is-hidden");
            } else {
                requestAnimationFrame(fade);
            }
        })();
    }

    function fadeIn(el, v, display) {
        if (el.classList.contains("is-hidden")) {
            el.classList.remove("is-hidden");
        }
        el.style.opacity = 0;
        el.style.display = display || "block";
        (function fade() {
            var val = parseFloat(el.style.opacity);
            if (!((val += 0.1) > v)) {
                el.style.opacity = val;
                requestAnimationFrame(fade);
            }
        })();
    }
    document.querySelector("#camera-select").addEventListener("change", function() {
        if (decoder.isInitialized()) {
            decoder.stop().play();
        }
    });
}).call(window.Page = window.Page || {});

function vendingdata(value)
{
    console.log(value);

    var Time_out = value.split(",").pop();

    var now = new Date();
    var timenow = now.getTime();



    if((timenow - Time_out) < 300000)
    {

        console.log(timenow - Time_out);
        if(oldQr !== Time_out) {

            oldQr = Time_out;



            console.log(Time_out);

            var vendingId = value.substr(0, value.indexOf('('));

            var productsarray = value.substring(
                value.lastIndexOf("(") + 1,
                value.lastIndexOf(")")
            );
            console.log("productsarray:" + productsarray);

            var userId = value.substring(
                value.lastIndexOf(")") + 1,
                value.lastIndexOf(",")
            );
            ;

            console.log("User:" + userId);

            var products = [];

            var p = productsarray.length;
            var number = "";

            for (p = 0; p < productsarray.length; p++) {

                if (productsarray.charAt(p) == ",") {
                    products.push(number);
                    number = "";
                } else {
                    number += productsarray.charAt(p);
                }
            }

            products.push(number);
            number = "";

            console.table(products);

            $.each(products, function (index, value) {

                console.log(vendingId + " | " + value);

                // voor elke position word het product er uit gehaald

                console.log(value);

                $.ajax({
                    url: "http://192.168.0.40/", //IP of Arduino
                    type: "POST",
                    data: {$vendingId: vendingId, productPosition: value + "@"},
                    dataType: 'jsonp',
                    contentType: 'application/json',
                    crossDomain: true,

                });

                // stock van product gaat omlaag

                $.ajax({
                    type: "POST",
                    dataType: "json",
                    data: {
                        vendingId: vendingId,
                        productPosition: value
                    },

                    url: "inc/removestock.php"
                });

                // elk product waar het postion- en user-id zijn gebruik word verwijderd uit het winkelmandje.


                // geld word van rekening afgehaald

                // transactie toevoegen aan transacties tabel

                $.ajax({
                    type: "POST",
                    dataType: "json",
                    data: {
                        userId: userId,
                        vendingId: vendingId,
                        productPosition: value
                    },

                    url: "inc/paymoney.php"
                });

            });
        }
        else
        {
            console.log("code is al gescanned");
        }
    }
    else
    {

        console.log("Code is too old!");
    }

}