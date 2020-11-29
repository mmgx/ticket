var backgroundLayer = new SchemeDesigner.Layer('background', {zIndex: 0, visible: false, active: false});
var defaultLayer = new SchemeDesigner.Layer('default', {zIndex: 10});

/**
 * Render place function
 * @param {SchemeObject} schemeObject
 * @param {Scheme} schemeDesigner
 * @param {View} view
 */
var renderPlace = function (schemeObject, schemeDesigner, view) {
    var context = view.getContext();

    var objectParams = schemeObject.getParams();

    var backgroundColor = '#' + objectParams.backgroundColor;

    context.beginPath();
    context.lineWidth = 4;
    context.strokeStyle = 'white';

    var isHovered = schemeObject.isHovered && !SchemeDesigner.Tools.touchSupported();

    context.fillStyle = backgroundColor;

    if (objectParams.isSelected && isHovered) {
        context.strokeStyle = backgroundColor;
    } else if (isHovered) {
        context.fillStyle = 'white';
        context.strokeStyle = backgroundColor;
    } else if (objectParams.isSelected) {
        context.strokeStyle = backgroundColor;
    }

    var relativeX = schemeObject.x;
    var relativeY = schemeObject.y;

    var width = schemeObject.getWidth();
    var height = schemeObject.getHeight();
    if (!isHovered && !objectParams.isSelected) {
        var borderOffset = 4;
        relativeX = relativeX + borderOffset;
        relativeY = relativeY + borderOffset;
        width = width - (borderOffset * 2);
        height = height - (borderOffset * 2);
    }

    var halfWidth = width / 2;
    var halfHeight = height / 2;

    var circleCenterX = relativeX + halfWidth;
    var circleCenterY = relativeY + halfHeight;

    if (schemeObject.getRotation()) {
        context.save();
        context.translate(relativeX + halfWidth, relativeY + halfHeight);
        context.rotate(schemeObject.getRotation() * Math.PI / 180);
        context.rect(-halfWidth, -halfHeight, width, height);
    } else {
        context.arc(circleCenterX, circleCenterY, halfWidth, 0, Math.PI * 2);
    }

    context.fill();
    context.stroke();

    context.font = (Math.floor((schemeObject.getWidth() + schemeObject.getHeight()) / 4)) + 'px Arial';

    if (objectParams.isSelected && isHovered) {
        context.fillStyle = 'white';
    } else if (isHovered) {
        context.fillStyle = backgroundColor;
    } else if (objectParams.isSelected) {
        context.fillStyle = 'white';
    }

    if (objectParams.isSelected || isHovered) {
        context.textAlign = 'center';
        context.textBaseline = 'middle';
        if (schemeObject.rotation) {
            context.fillText(objectParams.seat,
                -(schemeObject.getWidth() / 2) + (schemeObject.getWidth() / 2),
                -(schemeObject.getHeight() / 2) + (schemeObject.getHeight() / 2)
            );
        } else {
            context.fillText(objectParams.seat, relativeX + (schemeObject.getWidth() / 2), relativeY + (schemeObject.getHeight() / 2));
        }
    }

    if (schemeObject.rotation) {
        context.restore();
    }
};

/**
 * Render label function
 * @param {SchemeObject} schemeObject
 * @param {Scheme} schemeDesigner
 * @param {View} view
 */
var renderLabel = function (schemeObject, schemeDesigner, view) {
    var objectParams = schemeObject.getParams();
    var fontSize = (objectParams.fontSize >> 0) * (96 / 72) * 3;

    var context = view.getContext();

    context.fillStyle = '#' + objectParams.fontColor;
    context.font = fontSize + 'px Arial';
    context.textAlign = 'center';
    context.textBaseline = 'middle';
    context.fillText(objectParams.sectorName, schemeObject.getX(), schemeObject.getY());
};


var clickOnPlace = function (schemeObject, schemeDesigner, view, e) {
    var objectParams = schemeObject.getParams();
    objectParams.isSelected = !objectParams.isSelected;
};

/**
 * Creating places
 */
for (var i = 0; i < schemeData.length; i++) {
    var objectData = schemeData[i];
    var leftOffset = objectData.CX >> 0;
    var topOffset = objectData.CY >> 0;
    var width = objectData.Width >> 0;
    var height = objectData.Height >> 0;
    var rotation = objectData.Angle >> 0;

    var schemeObject = new SchemeDesigner.SchemeObject({
        /**
         * Required params
         */
        x: 0.5 + leftOffset,
        y: 0.5 + topOffset,
        width: width,
        height: height,
        active: objectData.ObjectType == 'Place' ? true : false,
        renderFunction: objectData.ObjectType == 'Place' ? renderPlace : renderLabel,
        cursorStyle: objectData.ObjectType == 'Place' ? 'pointer' : 'default',

        /**
         * Custom params (any names and count)
         */
        rotation: rotation,
        id: 'place_' + i,
        price: objectData.Price,
        seat: objectData.Seat,
        row: objectData.Row,
        sectorName: objectData.Name_sec,
        fontSize: objectData.FontSize,
        backgroundColor: objectData.BackColor,
        fontColor: objectData.FontColor,

        isSelected: false,
        clickFunction: clickOnPlace,
        clearFunction: function (schemeObject, schemeDesigner, view) {
            var context = view.getContext();

            var borderWidth = 5;
            context.clearRect(schemeObject.x - borderWidth,
                schemeObject.y - borderWidth,
                this.width + (borderWidth * 2),
                this.height + (borderWidth * 2)
            );
        }
    });

    defaultLayer.addObject(schemeObject);
}

/**
 * add background object
 */
backgroundLayer.addObject(new SchemeDesigner.SchemeObject({
    x: 0.5,
    y: 0.5,
    width: 8600,
    height: 7000,
    cursorStyle: 'default',
    renderFunction: function (schemeObject, schemeDesigner, view) {
        var context = view.getContext();
        context.beginPath();
        context.lineWidth = 4;
        context.strokeStyle = 'rgba(12, 200, 15, 0.2)';

        context.fillStyle = 'rgba(12, 200, 15, 0.2)';


        var width = schemeObject.width;
        var height = schemeObject.height;

        context.rect(schemeObject.x, schemeObject.y, width, height);


        context.fill();
        context.stroke();
    }
}));

var canvas = document.getElementById('canvas1');
var schemeDesigner = new SchemeDesigner.Scheme(canvas, {
    options: {
        cacheSchemeRatio: 2
    },
    scroll: {
        maxHiddenPart: 0.5
    },
    zoom: {
        padding: 0.1,
        maxScale: 8,
        zoomCoefficient: 1.04
    },
    storage: {
        treeDepth: 6
    }
});

/**
 * Adding layers with objects
 */
schemeDesigner.addLayer(defaultLayer);
schemeDesigner.addLayer(backgroundLayer);


/**
 * Show scheme
 */
schemeDesigner.render();

canvas.addEventListener('schemeDesigner.beforeRenderAll', function (e) {
    // console.time('renderAll');
}, false);

canvas.addEventListener('schemeDesigner.afterRenderAll', function (e) {
    // console.timeEnd('renderAll');
}, false);

canvas.addEventListener('schemeDesigner.clickOnObject', function (e) {
    // console.log('clickOnObject', e.detail);
    // arr.push(e.detail.id);
    places.pushIfNotExist(e.detail.id, function (el) {
        return el === e.detail.id;
    });
    // console.log(places);
}, false);

canvas.addEventListener('schemeDesigner.mouseOverObject', function (e) {
    // console.log('mouseOverObject', e.detail);
}, false);

canvas.addEventListener('schemeDesigner.mouseLeaveObject', function (e) {
    //  console.log('mouseLeaveObject', e.detail);
}, false);

canvas.addEventListener('schemeDesigner.scroll', function (e) {
    //  console.log('scroll', e.detail);
}, false);

canvas.addEventListener('schemeDesigner.zoom', function (e) {
    //  console.log('zoom', e.detail);
}, false);


Array.prototype.inArray = function (comparer) {
    for (var i = 0; i < this.length; i++) {
        if (comparer(this[i])) return true;
    }
    return false;
}

Array.prototype.pushIfNotExist = function (element, comparer) {
    if (!this.inArray(comparer)) {
        this.push(element);
    } else
        this.splice(this.indexOf(element), 1);
}


/**
 *
 * Запрос имя пользователя
 * @param places
 * @param event
 * @returns {Promise<void>}
 */
async function booking(places, event) {
    const {value: username} = await Swal.fire({
        title: 'Введите имя пользователя',
        input: 'text',
        inputLabel: 'Имя пользователя',
        showCancelButton: true,
        cancelButtonText: 'Отмена',
        inputPlaceholder: 'Введите имя пользователя'
    })

    if (username) {
        reserve(event, username);
    }
}

function reserve(event, username) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: 'POST',
        url: '/booking',
        data: {eventId: event, username: username, places: places},
        success: function (data) {
            Swal.fire({
                icon: 'success',
                title: 'Успешно забронировано. Бронь: ' + data.reservation_id,
                text: 'Забронированные места: ' + places,
                footer: 'Покупатель: ' + username
            })
        },
    });
}
