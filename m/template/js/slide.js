function imageInit() {
    if ($(".image_area").length && $(".bigimg_box").length) {
        $(".image_area").carousel({
            imgType:"thumb"
        });
        var thumbImg = $(".image_area").find("img");
        thumbImg.each(function (i) {
            $(this).bind("click", function () {
                if ($(".bigimg_box").find("img").size() == 0) {
                    thumbImg.each(function () {
                        var _bigSrc = $(this).attr("ref").replace("tiny", "big");
                        var _bigImg = document.createElement("img");
                        var _li = document.createElement("li");
                        _bigImg.src = "http://pic2.58.com/m58/m3/img/imglogo_gray.png";
                        _bigImg.setAttribute("ref", _bigSrc);
                        _li.appendChild(_bigImg);
                        document.querySelector(".bigimg_box ul").appendChild(_li);
                    });
                }
                setTimeout(function () {
                    window.scrollTo(0, 1);
                    $(".bigimg_box").carousel({
                        imgType:"big",
                        scrollTo:i
                    });
                }, 0);
                $("#viewBigImagebg").show().css("height", document.body.clientHeight + "px");
                $("#viewBigImage").show();
                var path = "/" + ____json4fe.locallist[0].listname + "/" + ____json4fe.rootcatentry.listname + "/" + ____json4fe.catentry.listname + "/detail/click/photo/";
                googleAnalytices(path, document.referer);
            });
        });
        $(".btn_back").bind("click", function () {
            $("#viewBigImagebg").hide();
            $("#viewBigImage").hide();
        });
    }
}



 
function FastClick(layer) {
    'use strict';
    var oldOnClick, self = this;
    this.trackingClick = false;
    this.trackingClickStart = 0;
    this.targetElement = null;
    this.touchStartX = 0;
    this.touchStartY = 0;
    this.lastTouchIdentifier = 0;
    this.touchBoundary = 10;
    this.layer = layer;
    if (!layer || !layer.nodeType) {
        throw new TypeError('Layer must be a document node');
    }
    this.onClick = function() {
        return FastClick.prototype.onClick.apply(self, arguments)
    };
    this.onMouse = function() {
        return FastClick.prototype.onMouse.apply(self, arguments)
    };
    this.onTouchStart = function() {
        return FastClick.prototype.onTouchStart.apply(self, arguments)
    };
    this.onTouchMove = function() {
        return FastClick.prototype.onTouchMove.apply(self, arguments)
    };
    this.onTouchEnd = function() {
        return FastClick.prototype.onTouchEnd.apply(self, arguments)
    };
    this.onTouchCancel = function() {
        return FastClick.prototype.onTouchCancel.apply(self, arguments)
    };
    if (FastClick.notNeeded(layer)) {
        return
    }
    if (this.deviceIsAndroid) {
        layer.addEventListener('mouseover', this.onMouse, true);
        layer.addEventListener('mousedown', this.onMouse, true);
        layer.addEventListener('mouseup', this.onMouse, true)
    }
    layer.addEventListener('click', this.onClick, true);
    layer.addEventListener('touchstart', this.onTouchStart, false);
    layer.addEventListener('touchmove', this.onTouchMove, false);
    layer.addEventListener('touchend', this.onTouchEnd, false);
    layer.addEventListener('touchcancel', this.onTouchCancel, false);
    if (!Event.prototype.stopImmediatePropagation) {
        layer.removeEventListener = function(type, callback, capture) {
            var rmv = Node.prototype.removeEventListener;
            if (type === 'click') {
                rmv.call(layer, type, callback.hijacked || callback, capture)
            } else {
                rmv.call(layer, type, callback, capture)
            }
        };
        layer.addEventListener = function(type, callback, capture) {
            var adv = Node.prototype.addEventListener;
            if (type === 'click') {
                adv.call(layer, type, callback.hijacked || (callback.hijacked = function(event) {
                    if (!event.propagationStopped) {
                        callback(event)
                    }
                }), capture)
            } else {
                adv.call(layer, type, callback, capture)
            }
        }
    }
    if (typeof layer.onclick === 'function') {
        oldOnClick = layer.onclick;
        layer.addEventListener('click',
        function(event) {
            oldOnClick(event)
        },
        false);
        layer.onclick = null
    }
}
FastClick.prototype.deviceIsAndroid = navigator.userAgent.indexOf('Android') > 0;
FastClick.prototype.deviceIsIOS = /iP(ad|hone|od)/.test(navigator.userAgent);
FastClick.prototype.deviceIsIOS4 = FastClick.prototype.deviceIsIOS && (/OS 4_\d(_\d)?/).test(navigator.userAgent);
FastClick.prototype.deviceIsIOSWithBadTarget = FastClick.prototype.deviceIsIOS && (/OS ([6-9]|\d{2})_\d/).test(navigator.userAgent);
FastClick.prototype.needsClick = function(target) {
    'use strict';
    switch (target.nodeName.toLowerCase()) {
    case 'button':
    case 'select':
    case 'textarea':
        if (target.disabled) {
            return true
        }
        break;
    case 'input':
        if ((this.deviceIsIOS && target.type === 'file') || target.disabled) {
            return true
        }
        break;
    case 'label':
    case 'video':
        return true
    }
    return (/\bneedsclick\b/).test(target.className)
};
FastClick.prototype.needsFocus = function(target) {
    'use strict';
    switch (target.nodeName.toLowerCase()) {
    case 'textarea':
        return true;
    case 'select':
        return ! this.deviceIsAndroid;
    case 'input':
        switch (target.type) {
        case 'button':
        case 'checkbox':
        case 'file':
        case 'image':
        case 'radio':
        case 'submit':
            return false
        }
        return ! target.disabled && !target.readOnly;
    default:
        return (/\bneedsfocus\b/).test(target.className)
    }
};
FastClick.prototype.sendClick = function(targetElement, event) {
    'use strict';
    var clickEvent, touch;
    if (document.activeElement && document.activeElement !== targetElement) {
        document.activeElement.blur()
    }
    touch = event.changedTouches[0];
    clickEvent = document.createEvent('MouseEvents');
    clickEvent.initMouseEvent(this.determineEventType(targetElement), true, true, window, 1, touch.screenX, touch.screenY, touch.clientX, touch.clientY, false, false, false, false, 0, null);
    clickEvent.forwardedTouchEvent = true;
    targetElement.dispatchEvent(clickEvent)
};
FastClick.prototype.determineEventType = function(targetElement) {
    'use strict';
    if (this.deviceIsAndroid && targetElement.tagName.toLowerCase() === 'select') {
        return 'mousedown'
    }
    return 'click'
};
FastClick.prototype.focus = function(targetElement) {
    'use strict';
    var length;
    if (this.deviceIsIOS && targetElement.setSelectionRange && targetElement.type.indexOf('date') !== 0 && targetElement.type !== 'time') {
        length = targetElement.value.length;
        targetElement.setSelectionRange(length, length)
    } else {
        targetElement.focus()
    }
};
FastClick.prototype.updateScrollParent = function(targetElement) {
    'use strict';
    var scrollParent, parentElement;
    scrollParent = targetElement.fastClickScrollParent;
    if (!scrollParent || !scrollParent.contains(targetElement)) {
        parentElement = targetElement;
        do {
            if (parentElement.scrollHeight > parentElement.offsetHeight) {
                scrollParent = parentElement;
                targetElement.fastClickScrollParent = parentElement;
                break
            }
            parentElement = parentElement.parentElement
        } while ( parentElement )
    }
    if (scrollParent) {
        scrollParent.fastClickLastScrollTop = scrollParent.scrollTop
    }
};
FastClick.prototype.getTargetElementFromEventTarget = function(eventTarget) {
    'use strict';
    if (eventTarget.nodeType === Node.TEXT_NODE) {
        return eventTarget.parentNode
    }
    return eventTarget
};
FastClick.prototype.onTouchStart = function(event) {
    'use strict';
    var targetElement, touch, selection;
    if (event.targetTouches.length > 1) {
        return true
    }
    targetElement = this.getTargetElementFromEventTarget(event.target);
    touch = event.targetTouches[0];
    if (this.deviceIsIOS) {
        selection = window.getSelection();
        if (selection.rangeCount && !selection.isCollapsed) {
            return true
        }
    }
    this.trackingClick = true;
    this.trackingClickStart = event.timeStamp;
    this.targetElement = targetElement;
    this.touchStartX = touch.pageX;
    this.touchStartY = touch.pageY;
    if ((event.timeStamp - this.lastClickTime) < 200) {
        event.preventDefault()
    }
    return true
};
FastClick.prototype.touchHasMoved = function(event) {
    'use strict';
    var touch = event.changedTouches[0],
    boundary = this.touchBoundary;
    if (Math.abs(touch.pageX - this.touchStartX) > boundary || Math.abs(touch.pageY - this.touchStartY) > boundary) {
        return true
    }
    return false
};
FastClick.prototype.onTouchMove = function(event) {
    'use strict';
    if (!this.trackingClick) {
        return true
    }
    if (this.targetElement !== this.getTargetElementFromEventTarget(event.target) || this.touchHasMoved(event)) {
        this.trackingClick = false;
        this.targetElement = null
    }
    return true
};
FastClick.prototype.findControl = function(labelElement) {
    'use strict';
    if (labelElement.control !== undefined) {
        return labelElement.control
    }
    if (labelElement.htmlFor) {
        return document.getElementById(labelElement.htmlFor)
    }
    return labelElement.querySelector('button, input:not([type=hidden]), keygen, meter, output, progress, select, textarea')
};
FastClick.prototype.onTouchEnd = function(event) {
    'use strict';
    var forElement, trackingClickStart, targetTagName, scrollParent, touch, targetElement = this.targetElement;
    if (!this.trackingClick) {
        return true
    }
    if ((event.timeStamp - this.lastClickTime) < 200) {
        this.cancelNextClick = true;
        return true
    }
    this.cancelNextClick = false;
    this.lastClickTime = event.timeStamp;
    trackingClickStart = this.trackingClickStart;
    this.trackingClick = false;
    this.trackingClickStart = 0;
    if (this.deviceIsIOSWithBadTarget) {
        touch = event.changedTouches[0];
        targetElement = document.elementFromPoint(touch.pageX - window.pageXOffset, touch.pageY - window.pageYOffset) || targetElement;
        targetElement.fastClickScrollParent = this.targetElement.fastClickScrollParent
    }
    targetTagName = targetElement.tagName.toLowerCase();
    if (targetTagName === 'label') {
        forElement = this.findControl(targetElement);
        if (forElement) {
            this.focus(targetElement);
            if (this.deviceIsAndroid) {
                return false
            }
            targetElement = forElement
        }
    } else if (this.needsFocus(targetElement)) {
        if ((event.timeStamp - trackingClickStart) > 100 || (this.deviceIsIOS && window.top !== window && targetTagName === 'input')) {
            this.targetElement = null;
            return false
        }
        this.focus(targetElement);
        if (!this.deviceIsIOS4 || targetTagName !== 'select') {
            this.targetElement = null;
            event.preventDefault()
        }
        return false
    }
    if (this.deviceIsIOS && !this.deviceIsIOS4) {
        scrollParent = targetElement.fastClickScrollParent;
        if (scrollParent && scrollParent.fastClickLastScrollTop !== scrollParent.scrollTop) {
            return true
        }
    }
    if (!this.needsClick(targetElement)) {
        event.preventDefault();
        this.sendClick(targetElement, event)
    }
    return false
};
FastClick.prototype.onTouchCancel = function() {
    'use strict';
    this.trackingClick = false;
    this.targetElement = null
};
FastClick.prototype.onMouse = function(event) {
    'use strict';
    if (!this.targetElement) {
        return true
    }
    if (event.forwardedTouchEvent) {
        return true
    }
    if (!event.cancelable) {
        return true
    }
    if (!this.needsClick(this.targetElement) || this.cancelNextClick) {
        if (event.stopImmediatePropagation) {
            event.stopImmediatePropagation()
        } else {
            event.propagationStopped = true
        }
        event.stopPropagation();
        event.preventDefault();
        return false
    }
    return true
};
FastClick.prototype.onClick = function(event) {
    'use strict';
    var permitted;
    if (this.trackingClick) {
        this.targetElement = null;
        this.trackingClick = false;
        return true
    }
    if (event.target.type === 'submit' && event.detail === 0) {
        return true
    }
    permitted = this.onMouse(event);
    if (!permitted) {
        this.targetElement = null
    }
    return permitted
};
FastClick.prototype.destroy = function() {
    'use strict';
    var layer = this.layer;
    if (this.deviceIsAndroid) {
        layer.removeEventListener('mouseover', this.onMouse, true);
        layer.removeEventListener('mousedown', this.onMouse, true);
        layer.removeEventListener('mouseup', this.onMouse, true)
    }
    layer.removeEventListener('click', this.onClick, true);
    layer.removeEventListener('touchstart', this.onTouchStart, false);
    layer.removeEventListener('touchmove', this.onTouchMove, false);
    layer.removeEventListener('touchend', this.onTouchEnd, false);
    layer.removeEventListener('touchcancel', this.onTouchCancel, false)
};
FastClick.notNeeded = function(layer) {
    'use strict';
    var metaViewport;
    var chromeVersion;
    if (typeof window.ontouchstart === 'undefined') {
        return true
    }
    chromeVersion = +(/Chrome\/([0-9]+)/.exec(navigator.userAgent) || [, 0])[1];
    if (chromeVersion) {
        if (FastClick.prototype.deviceIsAndroid) {
            metaViewport = document.querySelector('meta[name=viewport]');
            if (metaViewport) {
                if (metaViewport.content.indexOf('user-scalable=no') !== -1) {
                    return true
                }
                if (chromeVersion > 31 && window.innerWidth <= window.screen.width) {
                    return true
                }
            }
        } else {
            return true
        }
    }
    if (layer.style.msTouchAction === 'none') {
        return true
    }
    return false
};
FastClick.attach = function(layer) {
    'use strict';
    return new FastClick(layer)
};
if (typeof define !== 'undefined' && define.amd) {
    define(function() {
        'use strict';
        return FastClick
    })
} else if (typeof module !== 'undefined' && module.exports) {
    module.exports = FastClick.attach;
    module.exports.FastClick = FastClick
} else {
    window.FastClick = FastClick
}
FastClick.attach(document.body); (function() {
    if ($('.image_area ul').length > 0) {
        $('.bigimg_box ul').html($('.image_area ul').html().replace(/small/g, 'big').replace(/220/g, 300).replace(/155/g, 415))
    }
    var slideX = (function() {
        var _slide = function(node, duration, width, left, clickable) {
            this._eleX = 0;
            this._index = 0;
            this._length = node.children('li').length;
            this._main = node;
            this._startX = 0;
            this._startY = 0;
            this._duration = duration;
            this._width = width;
            this._left = left;
            this._clickable = clickable;
            $('.total_img').text(this._length)
        };
        _slide.prototype = {
            _bindEvents: function() {
                var _this = this;
                this._main.bind("touchstart",
                function(e) {
                    _this._touchStart(e, _this)
                });
                this._main.bind("touchmove",
                function(e) {
                    _this._touchMove(e, _this)
                });
                this._main.bind("touchend",
                function(e) {
                    _this._touchEnd(e, _this)
                })
            },
            _click: function() {
                if (this._clickable) {
                    var img = $(this._main.find('li img').get(this._index));
                    this._showImage(this._index);
                    $('.bigimg_box ul').css('-webkit-transform', 'translateX(-' + this._index * 320 + 'px)');
                    if (typeof bigimage !== 'undefined') {
                        bigimage._index = this._index;
                        bigimage._showImage(this._index);
                        bigimage._showImage(this._index + 1)
                    }
                    $('#viewBigImagebg').css('height', document.body.offsetHeight + 50 + 'px');
                    $('#viewBigImagebg, #viewBigImage').show()
                }
            },
            _showImage: function(index) {
                var img = $(this._main.find('li img').get(index));
                var ref = img.attr('ref');
                if (ref) {
                    img.attr('src', ref);
                    img.removeAttr('ref')
                }
            },
            _moveTo: function(x) {
                this._main.css({
                    '-webkit-transform': 'translateX(' + x + 'px)'
                })
            },
            _touchStart: function(e, _this) {
                e.stopPropagation();
                var finger0 = e.targetTouches[0];
                _this._startX = finger0.pageX;
                _this._startY = finger0.screenY;
                var transform = _this._main.css('-webkit-transform');
                var pattern = /\(|, {0,}|\)/;
                _this._eleX = (transform.indexOf('translate') >= 0) ? +transform.split(pattern)[1].replace('px', '') : +transform.split(pattern)[5]
            },
            _touchMove: function(e, _this) {
                var finger0 = e.targetTouches[0];
                var endX = finger0.pageX;
                var offsetX = endX - _this._startX + _this._eleX;
                if (Math.abs(endX - _this._startX) > 10) {
                    e.preventDefault();
                    e.stopPropagation();
                    _this._main.css('-webkit-transition', '0');
                    _this._moveTo(offsetX)
                }
            },
            _touchEnd: function(e, _this) {
                var finger0 = e.changedTouches[0];
                var endX = finger0.pageX;
                var endY = finger0.screenY;
                var offsetX = endX - _this._startX;
                var offsetY = endY - _this._startY;
                if (Math.abs(offsetX) <= 10) {
                    if (Math.abs(offsetY) <= 20) {
                        _this._click()
                    }
                } else {
                    var index = (offsetX > 0) ? --_this._index: ++_this._index;
                    if (index < 0) {
                        index = 0;
                        _this._index = 0
                    }
                    if (index >= _this._length) {
                        index = _this._length - 1;
                        _this._index = _this._length - 1
                    }
                    _this._showImage(index);
                    _this._showImage(index + 1);
                    $('.curr_img').text(index + 1);
                    _this._main.css('-webkit-transition', '150ms');
                    _this._moveTo( - index * _this._width + _this._left)
                }
            },
            init: function() {
                this._bindEvents();
                this._showImage(0);
                this._showImage(1)
            }
        };
        _slide.bind = function(node, duration, width, left, clickable) {
            var obj = new m58.slideX(node, duration, width, left, clickable);
            obj.init();
            return obj
        };
        return _slide
    })();
    window.m58 = window.m58 || {};
    window.m58.slideX = slideX;
    if ($('.image_area').length > 0) {
        m58.slideX.bind($('.image_area ul'), '300ms', 230, 50, true);
        var bigimage = m58.slideX.bind($('.bigimg_box ul'), '300ms', 320, 0, false)
    }
    $('.btn_back span').bind('click',
    function(e) {
        $('#viewBigImagebg, #viewBigImage').hide()
    })
} ());