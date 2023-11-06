(function () {
        var setting = {"height":350,"width":450,"zoom":17,"queryString":"Rua Natal, 2800 - Recanto Tropical, Cascavel - PR, Brasil","place_id":"EjlSdWEgTmF0YWwsIDI4MDAgLSBSZWNhbnRvIFRyb3BpY2FsLCBDYXNjYXZlbCAtIFBSLCBCcmFzaWwiMRIvChQKEgkt-fu8U9HzlBHaIOwLjY0UuxDwFSoUChIJMc4FnADU85QROAML22mm0I8","satellite":false,"centerCoord":[-24.947217707387296,-53.48371819999999],"cid":"0x478092c7fae703cb","lang":"pt","cityUrl":"/brazil/cascavel-37536","cityAnchorText":"","id":"map-9cd199b9cc5410cd3b1ad21cab2e54d3","embed_id":"933303"};
        var d = document;
        var s = d.createElement('script');
        s.src = 'https://1map.com/js/script-for-user.js?embed_id=933303';
        s.async = true;
        s.onload = function (e) {
          window.OneMap.initMap(setting)
        };
        var to = d.getElementsByTagName('script')[0];
        to.parentNode.insertBefore(s, to);
      })();

