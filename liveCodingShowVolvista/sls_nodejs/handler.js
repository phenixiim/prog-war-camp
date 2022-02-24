'use strict';

var url = require('url');
var request = require('request');
var targetUrl = 'https://www.volvista.cz/ojete-vozy?carCheck2=BZR&fPrevodovka=&fNahon=59&fKm=&fFuel=&fNovinka=Y&fPobocka=&fYearFrom=1957&fYearTo=2022&fPriceFrom=150000&fPriceTo=2400000&fView=R&fSort=&fOnPage=20&fSortDesc=0&fSetOrder=&fSortDescMobile=&fSetOrderMobile=&fCount=20&fScroll=1&fLeasing=&fResetSearching=1&hlidaniLosem=&filtrace=1&page=ojete-vozy#anchor';
var md5OfTheOriginalCarsListHtml = '020ded734626c3d77f7487d06ecb998e';
var MESSENGER_WEBHOOK_URL = 'https://hook.integromat.com/198owikj3y90e86xq9mnlxpu2tuno72p';

const timeout = 100;

module.exports.test = function (event, context, callback) {
    verifyPageIfChanged(targetUrl, callback);
};

function verifyPageIfChanged(targetUrl, callback) {
    performTargetPageCheck(targetUrl, callback);
}

function performTargetPageCheck(targetUrl, callback) {
    var urlObject = url.parse(targetUrl);
    var mod = require(
        urlObject.protocol.substring(0, urlObject.protocol.length - 1)
    );

    var onFail = function (e) {
        console.log('something has failed...');
    };
    console.log('[INFO] - Checking ' + targetUrl);
    var req = mod.request(urlObject, function (res) {
        var html = '';
        res.setEncoding('utf8');
        res.socket.on('timeout', function () {
            console.log('[TIMEOUT] - timeouted.');

            req.abort();
        });
        res.on('data', function (chunk) {
            console.log('[INFO] - Read body chunk');
            html += chunk;
        });
        res.on('end', function () {
            console.log('[INFO] - Response end');

            var re = new RegExp('<section.+vozy-vypis">(.*)</section>', 's');
            var r = html.match(re);
            let carsListHtml = r[1];

            let carsCount = (carsListHtml.match(new RegExp("cars-item", "g")) || []).length;
            console.log('cars count:' + carsCount);

            var crypto = require('crypto');
            var md5HashOfTargetPageCarsListHtml = crypto.createHash('md5').update(carsListHtml).digest('hex');

            if (md5HashOfTargetPageCarsListHtml != md5OfTheOriginalCarsListHtml) {
                sendAlert(md5HashOfTargetPageCarsListHtml, carsCount);
                return;
            }

            sendCheckOk(md5HashOfTargetPageCarsListHtml, carsCount);

            console.log('The page has not been changed.');
        });


    }).setTimeout(timeout);
    req.on('error', onFail);
    req.end();
}

function sendCheckOk(newHash, carsCount) {
    console.log('posilam ok zpravu....');
    let message = 'žádná změna, počet vozů je:' + carsCount;
    sendSlackMessage(message);
}

function sendAlert(newHash, carsCount) {
    console.log('posilam alert....');
    let message = 'POZOR! Změnila se stránka ' + targetUrl + ', počet vozů je:' + carsCount + 'novy hash je: ' + newHash;
    sendSlackMessage(message);
}

function sendSlackMessage(message) {
    request.post(
        MESSENGER_WEBHOOK_URL,
        {json: {text: message}},
        function (error, response, body) {
            if (!error && response.statusCode == 200) {
                console.log('zprava odeslana do Slacku');
            } else {
                console.log('ERROR:' + error + response.statusCode);
            }
        }
    );
};