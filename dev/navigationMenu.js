var ivoPetkov = ivoPetkov || {};
ivoPetkov.bearFrameworkAddons = ivoPetkov.bearFrameworkAddons || {};
ivoPetkov.bearFrameworkAddons.navigationMenu = ivoPetkov.bearFrameworkAddons.navigationMenu || (function () {

    var make = function (elementID, typeAttributeName, moreElementHTML) {
        var element = document.getElementById(elementID);
        var moreElement = null;

        var updating = false;
        var lastUpdatedKey = null;
        var update = function () {
            if (updating) {
                return;
            }

            var elementRect = element.getBoundingClientRect();
            var type = element.getAttribute(typeAttributeName);
            if (type === null) {
                type = 'none';
            }

            var updateKey = JSON.stringify([type, elementRect.top, elementRect.left, elementRect.width, elementRect.height]);
            if (lastUpdatedKey === updateKey) {
                return;
            }

            updating = true;
            element.style.overflow = 'hidden'; // prevent resize

            // update children position
            var updateChildren = function (level, UlContainer) {
                var ulChildren = UlContainer.childNodes;
                var ulChildrenCount = ulChildren.length;
                for (var i = 0; i < ulChildrenCount; i++) {
                    var liElement = ulChildren[i];
                    if (liElement.childNodes.length > 1) {
                        var firstChild = liElement.firstChild;
                        if (firstChild.tagName.toLowerCase() === 'a') {
                            if (type === 'none') {
                                if (typeof (firstChild.nmts) !== 'undefined') {
                                    delete firstChild.nmts;
                                }
                                if (typeof (firstChild.nmtsh) !== 'undefined') {
                                    firstChild.removeEventListener("touchstart", firstChild.nmtsh);
                                    delete firstChild.nmtsh;
                                }
                            } else {
                                if (typeof (firstChild.nmtsh) === 'undefined') {
                                    // remove href on first touch, then bring it back
                                    firstChild.nmtsh = function (event) {
                                        var liElement = this.parentNode;
                                        if (typeof (this.nmts) !== 'undefined') {
                                            if (liElement === moreElement) {
                                                liElement.lastChild.style.display = "none";
                                            } else {
                                                if (this.htmlnavth.length > 0) {
                                                    this.href = this.htmlnavth;
                                                }
                                            }
                                            delete this.nmts;
                                        } else {
                                            if (liElement === moreElement) {
                                                liElement.lastChild.style.removeProperty('display');
                                            } else {
                                                if (typeof (this.htmlnavth) === 'undefined') {
                                                    this.htmlnavth = this.href;
                                                }
                                                this.href = 'javascript:void(0);';
                                            }
                                            this.nmts = 1;
                                        }
                                    };
                                    firstChild.addEventListener("touchstart", firstChild.nmtsh, false);
                                }
                            }
                        }
                        var liElementUL = liElement.lastChild;
                        if (type === 'none') {
                            liElementUL.style.removeProperty("left");
                            liElementUL.style.removeProperty("top");
                        } else {
                            var maxWidth = document.body.clientWidth;
                            liElementUL.style.left = "-99999px";
                            liElementUL.style.display = "inline-block";
                            liElementUL.style.maxWidth = maxWidth + 'px';
                            var ulChildRect = liElement.getBoundingClientRect();
                            var ulChildULRect = liElementUL.getBoundingClientRect();
                            var left = 0;
                            var top = 0;
                            if (type === 'horizontal-down') {
                                if (liElement === moreElement) {
                                    left -= ulChildULRect.width - ulChildRect.width;
                                } else {
                                    left = level > 0 ? ulChildRect.width : 0;
                                }
                            } else if (type === 'vertical-right') {
                                left = ulChildRect.width;
                            } else if (type === 'vertical-left') {
                                left = -ulChildULRect.width;
                            }
                            var updateTop = false;
                            var overflowRight = (ulChildULRect.left + ulChildULRect.width + 99999) - maxWidth + left;
                            if (overflowRight > 0) {
                                left -= overflowRight;
                                updateTop = true;
                            }
                            var overflowLeft = -((ulChildULRect.left + 99999) + left);
                            if (overflowLeft > 0) {
                                left += overflowLeft;
                                updateTop = true;
                            }
                            if (updateTop) {
                                if ((type === 'horizontal-down' && level > 0) || type === 'vertical-right' || type === 'vertical-left') { // Move the overflown lists down so the parent can be accessed. It's an edge case.
                                    top += ulChildRect.height * 3 / 4;
                                }
                            }
                            liElementUL.style.left = Math.floor(left) + 'px';
                            liElementUL.style.top = Math.floor((type === 'horizontal-down' && level === 0 ? ulChildRect.height : 0) + top) + "px";
                            updateChildren(level + 1, liElementUL);
                            liElementUL.style.removeProperty("display");
                        }
                    }
                }
            };

            // move the elements in the more container back to their places
            if (moreElement !== null) {
                for (var i = 0; i < 99999; i++) {
                    var moreChildrenContainer = moreElement.lastChild;
                    if (moreChildrenContainer.firstChild === null) {
                        break;
                    }
                    moreElement.parentNode.appendChild(moreChildrenContainer.firstChild);
                }
            }

            var hasOverflow = false;
            if (type === 'horizontal-down') {
                var lastChildRect = element.lastChild.getBoundingClientRect();
                if (lastChildRect.left + lastChildRect.width > elementRect.left + elementRect.width) { // has overflow
                    if (moreElement === null) {
                        var temp = document.createElement("div");
                        temp.innerHTML = moreElementHTML;
                        moreElement = temp.firstChild; // li expected
                        element.appendChild(moreElement);
                    }
                    var moreElementRect = moreElement.getBoundingClientRect();
                    var children = element.childNodes;
                    var firstOverflowedChild = null;
                    for (var i = 0; i < children.length; i++) {
                        var child = children[i];
                        if (child !== moreElement) {
                            var childRect = child.getBoundingClientRect();
                            if (childRect.left + childRect.width + moreElementRect.width > elementRect.left + elementRect.width) {
                                firstOverflowedChild = children[i];
                                break;
                            }
                        }
                    }
                    element.insertBefore(moreElement, firstOverflowedChild); // move the more element at the right position
                    for (var i = 0; i < 99999; i++) {
                        if (!moreElement.nextSibling) {
                            break;
                        }
                        moreElement.lastChild.appendChild(moreElement.nextSibling);
                    }
                    hasOverflow = true;
                }
            }

            if (!hasOverflow) {
                if (moreElement !== null) {
                    moreElement.parentNode.removeChild(moreElement);
                    moreElement = null;
                }
            }

            updateChildren(0, element);

            element.style.overflow = 'initial';
            lastUpdatedKey = updateKey;
            updating = false;
        };

        update();

        if (typeof MutationObserver !== 'undefined') {
            var previousChangeKey = null;
            (new MutationObserver(function () {
                var changeKey = element.getAttribute(typeAttributeName);
                if (changeKey !== previousChangeKey) {
                    previousChangeKey = changeKey;
                    update();
                }
            })).observe(element, { attributes: true });
        }
        if (typeof ResizeObserver !== 'undefined') {
            (new ResizeObserver(update)).observe(element);
        }
        window.addEventListener('resize', update);
        window.addEventListener('orientationchange', update);
    };

    return {
        'make': make
    };
}());