const KEY = 'tuanphpvn::simpleblockwebsite::listwebsite';

chrome.webRequest.onBeforeRequest.addListener(details => {
  try {
    var strWebsite = localStorage[KEY];
    let arrDenyWebsite = JSON.parse(strWebsite);

    if (!strWebsite) {
      return;
    }

    const url = new URL(details.url);

    console.log(url.hostname);
    let arrMatch = arrDenyWebsite.filter((item) => {
      return -1 !== url.hostname.indexOf(item)
    });
    const isCancel = arrMatch.length > 0;
    if (isCancel) {
      for (let i = 0; i < 1000; i++) {
        alert('You are promise me. Don\'t enter this site!!!');
      }
    }

    return {
      cancel: isCancel
    };
  } catch (err) {
    console.error(err.stack);
    return {
      cancel: false
    };
  }
}, {
  urls: ['<all_urls>']
}, ['blocking']);