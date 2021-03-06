$(function(){

    var conference = {
        short_name: 'COMSOLiD',
        full_name: 'Comunidade Maracanauense de Software Livre e Inclusão Digital',
        starts_at:  moment(new Date(2014, 11, 16, 8, 0)),
        ends_at:  moment(new Date(2014, 11, 19, 17, 0)),
        features: {
            columns: 3,
            list: [
                {
                    title: 'Feature 1',
                    description: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero. Sed cursus ante dapibus diam. Sed nisi. Nulla quis sem at nib.',
                    icon: 'fa-graduation-cap'
                },
                {
                    title: 'Feature 2',
                    description: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero. Sed cursus ante dapibus diam. Sed nisi. Nulla quis sem at nib.',
                    icon: 'fa-gamepad'
                },
                {
                    title: 'Feature 3',
                    description: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero. Sed cursus ante dapibus diam. Sed nisi. Nulla quis sem at nib.',
                    icon: 'fa-desktop'
                }
            ]
        },
        social_networks: [
            {
                url: 'https://twitter.com/comsolid',
                channel: 'twitter'
            },
            {
                url: 'https://facebook.com/comsolid',
                channel: 'facebook'
            },
            {
                url: 'https://github.com/comsolid',
                channel: 'github'
            },
        ],
        map: {
            latitude: -3.87259,
            longitude: -38.610976,
            zoom: 17,
            address: 'Instituto Federal do Ceará - Campus Maracanaú - Av. Parque Central - Distrito Industrial I Maracanaú - CE'
        }
    };

    /* map configuration */
    var map = L.map('map').setView([conference.map.latitude, conference.map.longitude], conference.map.zoom);
    var mapLink = '<a href="http://openstreetmap.org">OpenStreetMap</a>';
    L.tileLayer(
        'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; ' + mapLink + ' Contributors',
        maxZoom: 18,
    }).addTo(map);
    L.marker([conference.map.latitude, conference.map.longitude]).addTo(map);
    /* end of map configuration */

    moment.lang('pt-br');
    $('#countdown').attr('data-date', conference.starts_at.format('YYYY-MM-DD HH:mm:ss'));

    var countdown = $('#countdown').TimeCircles({
        animation: 'ticks',
        count_past_zero: false,
        time: {
            Days: {
                show: true,
                text: _('Days'),
                color: '#feb23c'
            },
            Hours: {
                show: true,
                text: _('Hours'),
                color: '#61c8fa'
            },
            Minutes: {
                show: true,
                text: _('Minutes'),
                color: '#abe15c'
            },
            Seconds: {
                show: true,
                text: _('Seconds'),
                color: '#fd5936'
            }
        }
    });

    var intervalId = setInterval(function () {
        if (countdown.getTime() <= 0) {
            countdown.end().fadeOut(400, function () {
                $('#countdown-title').hide().addClass('fadeOutRight animated');
                $('#banner-index').show().addClass('lightSpeedIn animated');;
            });
            clearInterval(intervalId);
        }
    }, 1000);

    //var EVENT_ANIMATION_END = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';

    $('#fullpage').fullpage({
        sectionsColor: ['#ffffff', '#feb23c', '#61c8fa', '#abe15c', '#fd5936'],
        anchors: ['page-0', 'page-1', 'page-2', 'page-3'],
        menu: 'ul.nav',
        loopTop: true,
        loopBottom: true,
        css3: true,
        resize: false,
        afterLoad: function (anchorLink, index) {
            if(anchorLink == 'page-1') {
                $('.col-features').addClass('show fadeInUp animated');
                $('#header-features').addClass('show fadeInDown animated');
            } else if(anchorLink == 'page-2') {
                $('#col-address').addClass('show fadeInLeft animated');
                $('#col-map').addClass('show fadeInRight animated');
            } else if(anchorLink == 'page-3') {
                var socialButtons = $('#social-buttons');
                socialButtons.addClass('show');
                socialButtons.children('.btn').addClass('bounceInUp animated');
                $('#col-social').addClass('show flipInX animated');
                $('#col-footer').addClass('show fadeInUp animated');
            }
        },
        afterRender: function () {
            $('#col-login').addClass('show fadeInLeft animated');
            $('#col-participate').addClass('show fadeInRight animated');
        }
    });

    function generateConferenceFeatures(features) {
        var columns = features.columns || 3;
        var columnClass = 'col-md-4 col-sm-4';
        if (columns === 2) {
            columnClass = 'col-md-6 col-sm-6';
        } else {
            columnClass = 'col-md-4 col-sm-4';
        }
        columnClass += ' col-features hide';

        var row = $('#features');

        var list = features.list;
        var len = list.length;
        for (var i = 0; i < len; i++) {
            var item = list[i];
            $('<div></div>')
                    .attr('class', columnClass)
                    .html(_templateFeatureItem(item))
                    .appendTo(row);
        }
    }

    function _templateFeatureItem(item) {
        return sprintf(
            '<h3>%(title)s</h3><p>%(description)s</p><i class="fa %(icon)s fa-5x"></i>'
        , item);
    }

    function generateSocialButtons(list) {
        var social = $('#social-buttons');
        var len = list.length;
        for (var i = 0; i < len; i++) {
            var item = list[i];
            $(_templateSocialButtons(item)).appendTo(social);
        }
    }

    function _templateSocialButtons(item) {
        return sprintf(
            '<a href="%(url)s" class="btn btn-lg btn-%(channel)s" target="_blank"><i class="fa fa-%(channel)s"></i>&nbsp;&nbsp; %(channel)s</a>'
        , item);
    }

    $('#address').html(conference.map.address);
    $('#short_name').html(conference.short_name);
    $('#full_name').html(conference.full_name);
    generateConferenceFeatures(conference.features);
    generateSocialButtons(conference.social_networks);

    $('#datetime').html(
        conference.starts_at.format('DD/MM/YYYY - ') +
        conference.ends_at.format('DD/MM/YYYY')
    );
});
