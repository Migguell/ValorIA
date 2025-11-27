(function($) {
    /**
     * @param $scope The Widget wrapper element as a jQuery element
     * @param $ The jQuery alias
     */
    var WidgetCMSVideoHandler = function($scope, $) {
        var videoEls = $scope.find('.cms-evideo-frame');
        var apiProvider = elementorFrontend.utils['youtube'];
        var videoLink = getSettings('video_link');
        var videoId = apiProvider.getVideoIDFromURL(videoLink);
        var lightbox = getSettings('lightbox');

        onYouTubeIframeAPIReady(function() {
            if (lightbox != 'yes') {
                videoEls.each(function(index, videoEl) {
                    videoEl = $(videoEl);
                    let videoBtn = videoEl.parents('.cms-evideo').find('.cms-btn-video-bg');
                    videoBtn.on('click', function(e) {
                        e.preventDefault();
                        //$(this).hide();
                        //let ytEl = $('<div class="yt-video"></div>');
                        let ytEl = videoEls.find('.yt-video');
                        videoEl.html(ytEl).css({'z-index':'3'});
                        let autoplay = 1;
                        let mute = 0;
                        let loop = 1;
                        let ytPlayer = {};
                        let playerOptions = {
                            videoId: videoId, //iYf3OgEdGmo
                            events: {
                                onReady: () => {
                                    if (mute) {
                                        ytPlayer.mute();
                                    }
                                    if (autoplay) {
                                        ytPlayer.playVideo();
                                    }
                                },
                                onStateChange: event => {
                                    if (event.data === YT.PlayerState.ENDED && loop) {
                                      ytPlayer.seekTo(0); // loop
                                    }
                                }
                            },
                            playerVars: {
                                controls: 0,
                                // rel: 1,
                                playsinline: 1,
                                modestbranding: 0,
                                autoplay: autoplay,
                                loop: 1,
                            }
                        };
                        ytPlayer = new YT.Player(ytEl[0], playerOptions);
                    });
                });
            }
        });

        function onYouTubeIframeAPIReady(callback) {
            if (YT.loaded == 1) {
                callback();
            } else {
                setTimeout(function() {
                    console.log('Wating for YouTube Iframe API Ready!');
                    onYouTubeIframeAPIReady(callback);
                }, 1000);
            }
        }

        function getSettings(setting) {
            let settings = {};
            const modelCID = $scope.data('model-cid') || '',
                isEdit = $scope.hasClass('elementor-element-edit-mode');
            if (isEdit && modelCID) {
                const data = elementorFrontend.config.elements.data[modelCID],
                    attributes = data.attributes;
                let type = attributes.widgetType || attributes.elType;
                if (attributes.isInner) {
                    type = 'inner-' + type;
                }
                let dataKeys = elementorFrontend.config.elements.keys[type];
                if (!dataKeys) {
                    dataKeys = elementorFrontend.config.elements.keys[type] = [];
                    $.each(data.controls, (name, control) => {
                        if (control.frontend_available) {
                            dataKeys.push(name);
                        }
                    });
                }
                $.each(data.getActiveControls(), function(controlKey) {
                    if (-1 !== dataKeys.indexOf(controlKey)) {
                        let value = attributes[controlKey];
                        if (value.toJSON) {
                            value = value.toJSON();
                        }
                        settings[controlKey] = value;
                    }
                });
            } else {
                settings = $scope.data('settings') || {};
            }
            return getItems(settings, setting);
        }

        function getItems(items, itemKey) {
            if (itemKey) {
                const keyStack = itemKey.split('.'),
                    currentKey = keyStack.splice(0, 1);
                if (!keyStack.length) {
                    return items[currentKey];
                }
                if (!items[currentKey]) {
                    return;
                }
                return this.getItems(items[currentKey], keyStack.join('.'));
            }
            return items;
        }
    };

    // Make sure you run this code under Elementor.
    $(window).on('elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction('frontend/element_ready/cms_video_player.default', WidgetCMSVideoHandler);
    });
})(jQuery);