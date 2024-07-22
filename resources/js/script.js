document.addEventListener("DOMContentLoaded", function () {
    //color to card
    const inputs = document.querySelectorAll('.color input[type="radio"]')
    inputs.forEach(input => {
        let color = input.value,
            label = input
        label.style.backgroundColor = color
        label.style.border = "2px solid"
        label.style.borderColor = color === 'white' ? '#D9D9D9' : 'white'
    })
    if (document.querySelector(".top-prodaz-card")) {
        const cardView = document.querySelectorAll(".top-prodaz-card")
        cardView.forEach(itemCard => {
            if (window.innerWidth < 1024) {
                itemCard.classList.add("mobile-top-prodaz")
                itemCard.classList.remove("top-prodaz-card")
            } else {
                itemCard.classList.remove("mobile-top-prodaz")
                itemCard.classList.add("top-prodaz-card")

            }
        })

    }
    const image = document.querySelectorAll(".card img")

    image.forEach(itemImg => {
        itemImg.addEventListener("click", function () {
            var targetUrl = "card.html"

            window.location.href = targetUrl
        })
    })

    //view catalog chacge
    if (document.querySelector(".catalog-container")) {
        const catalogContainer = document.querySelector(".catalog-container"),
            boxBtn = document.querySelector(".box a"),
            lineBtn = document.querySelector(".line a"),
            catalogCard = catalogContainer.querySelectorAll("figure")

        lineBtn.addEventListener("click", function () {
            this.classList.add("active-btn-card-line")
            boxBtn.classList.remove("active-btn-card")
            catalogContainer.classList.add("line-catalog")
            catalogContainer.classList.remove("grid-catalog")
            catalogCard.forEach(itemCard => {
                itemCard.querySelector(".card-view-block").classList.add("grig-card-line")
                itemCard.querySelector(".main-info-card").classList.add("d-flex")
                itemCard.querySelector("picture").classList.add("picture-line")
                itemCard.querySelector(".flag").classList.add("flag-line")
            })
        })
        boxBtn.addEventListener("click", function () {
            this.classList.add("active-btn-card")
            lineBtn.classList.remove("active-btn-card-line")
            catalogContainer.classList.remove("line-catalog")
            catalogContainer.classList.add("grid-catalog")
            catalogCard.forEach(itemCard => {
                itemCard.querySelector(".card-view-block").classList.remove("grig-card-line")
                itemCard.querySelector(".main-info-card").classList.remove("d-flex")
                itemCard.querySelector("picture").classList.remove("picture-line")
                itemCard.querySelector(".flag").classList.remove("flag-line")
            })
        })

    }
    //submit click on select count
    document.querySelectorAll('.select__item').forEach(item => {
        item.addEventListener('click', function () {
            const value = this.getAttribute('data-value')
            document.querySelector('.select__input').value = value
            document.querySelector('#countForm').submit()
            document.querySelector('#sortForm').submit()
        })
    })
    //search mobile
    if (window.innerWidth < 1024) {
        const search = document.querySelector(".search-mobile"),
            searchBlock = document.querySelector(".search-block"),
            header = document.querySelector("header")

        search.addEventListener("click", function () {
            searchBlock.classList.toggle("search-mobile-form")
            header.classList.toggle("padding-for-search")
        })
    }

    function rearrangeSections() {
        if (window.innerWidth < 1024) {
            const sections = [{
                    buttonSelector: '.haracteristic-btn a',
                    targetAttr: 'data-target',
                    sectionSelector: '.description-product, .haracteristic-block, .comment-card, .delivery-card',
                    initialButtonSelector: '.transparent-cta[data-target="about"]',
                    initialSectionId: 'about',
                    readmoreClass: 'readmore',
                    moreClass: 'description-more',
                    activeClass: 'readmore-active',
                    visibleClass: 'visible'
                },
                {
                    buttonSelector: '.menu-help-item a',
                    targetAttr: 'data-href',
                    sectionSelector: '.help-content',
                    initialButtonSelectorNoActive: '', //якщо треба зробити щось активним тоді додати туди селектор
                    initialSectionId: 'aboutUs',
                    readmoreClass: 'readmore',
                    moreClass: 'description-more',
                    activeClass: 'readmore-active',
                    visibleClass: 'visible'
                }
            ]

            sections.forEach(({
                buttonSelector,
                targetAttr,
                sectionSelector,
                initialButtonSelector,
                initialSectionId,
                readmoreClass,
                moreClass,
                activeClass,
                visibleClass
            }) => {
                document.querySelectorAll(buttonSelector).forEach(button => {
                    let targetId = button.getAttribute(targetAttr)
                    let targetSection = document.getElementById(targetId)
                    if (targetSection) {
                        button.insertAdjacentElement('afterend', targetSection)
                    }
                })

                document.querySelectorAll(`${buttonSelector}[${targetAttr}]`).forEach(button => {
                    button.classList.add(readmoreClass)
                })

                document.querySelectorAll(sectionSelector).forEach(section => {
                    section.classList.add(moreClass)
                })

                const initialButton = document.querySelector(initialButtonSelector),
                    initialSection = document.getElementById(initialSectionId)

                if (initialButton && initialSection) {
                    initialButton.classList.add(activeClass)
                    initialSection.classList.add(visibleClass)
                }
            })
        }
    }

    function handleHashChange() {
        if (window.innerWidth < 1024) {
            const hash = window.location.hash.substring(1) // Remove the '#' from the hash
            if (hash) {
                document.querySelectorAll('.help-content').forEach(section => {
                    section.classList.remove('visible')
                    console.log(section)
                })

                document.querySelectorAll('.menu-help-item a').forEach(button => {
                    button.classList.remove('readmore-active')
                })

                const targetLink = document.querySelector(`.menu-help-item a[data-href="${hash}"]`)
                const targetSection = document.getElementById(hash)

                if (targetLink && targetSection) {
                    targetLink.classList.add('readmore-active')
                    targetSection.classList.add('visible')
                }
            }
        }
    }

    document.querySelectorAll('.help-sub-menu a').forEach(link => {
        link.addEventListener('click', function () {
            setTimeout(handleHashChange, 0)
        })
    })

    rearrangeSections()
    handleHashChange()
    window.addEventListener('hashchange', handleHashChange)

    if (document.querySelector(".menu-cabinet-item")) {
        const menuItems = document.querySelectorAll('.menu-cabinet-item a'),
            cabinetTopProdaz = document.querySelector('.cabinet-top-prodaz')

        menuItems.forEach(item => {
            item.addEventListener('click', function () {
                const dataHref = item.getAttribute('data-href')

                if (dataHref === 'cartCabinet') {
                    cabinetTopProdaz.style.display = 'block'
                } else {
                    cabinetTopProdaz.style.display = 'none'
                }
            })
        })
    }

    // window.addEventListener('resize', rearrangeSections)

    const blackFon = document.querySelector(".black-fon")
    //down menu mobile and decstop
    if (document.querySelector('.down-menu')) {
        if (window.innerWidth >= 1024) {
            const menuItems = document.querySelectorAll('.down-menu'),
                body = document.querySelector("#body"),
                listItemMain = document.querySelectorAll(".navigation-menu-catalog > li"),
                subMenuSecond = document.querySelectorAll(".sub-menu > li")
            //sub menu header
            //ховер при наведені на головній навігації
            const addHoverClass = (element, className) => element.classList.add(className),
                removeHoverClass = (element, className) => element.classList.remove(className)

            listItemMain.forEach(listItem => {
                listItem.addEventListener("mousemove", function () {
                    const link = this.querySelector("a"),
                        subMenu = this.querySelector(".sub-menu-main") || this.querySelector(".help-sub-menu")

                    if (link) addHoverClass(link, "yellow-header-hover")
                    if (subMenu) addHoverClass(subMenu, subMenu.classList.contains("sub-menu-main") ? "hover-sub-menu" : "hover-help-menu")
                })
                listItem.addEventListener("mouseleave", function () {
                    const link = this.querySelector("a"),
                        subMenu = this.querySelector(".sub-menu-main") || this.querySelector(".help-sub-menu")

                    if (link) removeHoverClass(link, "yellow-header-hover")
                    if (subMenu) removeHoverClass(subMenu, subMenu.classList.contains("sub-menu-main") ? "hover-sub-menu" : "hover-help-menu")
                })
            })

            subMenuSecond.forEach(subMenuSecList => {
                subMenuSecList.addEventListener("mousemove", function () {
                    addHoverClass(this, "hover-sub-sub-a")
                    const secondSubMenu = this.querySelector(".second-subMenu")
                    if (secondSubMenu) addHoverClass(secondSubMenu, "subSecond-hover")
                })
                subMenuSecList.addEventListener("mouseleave", function () {
                    removeHoverClass(this, "hover-sub-sub-a")
                    const secondSubMenu = this.querySelector(".second-subMenu")
                    if (secondSubMenu) removeHoverClass(secondSubMenu, "subSecond-hover")
                })
            })

            menuItems.forEach(item => {
                const subMenu = item.nextElementSibling,
                    blackFon = document.querySelector(".black-fon")
                console.log(blackFon)
                // listItemMenu = document.querySelector(".navigation-menu-catalog > li")
                console.log(subMenu)
                const showMenu = () => {
                    blackFon.classList.add("black-fon-style")
                    blackFon.style.display = 'block'

                }

                const hideMenu = () => {
                    blackFon.classList.remove("black-fon-style")
                    blackFon.style.display = 'none'
                }

                item.addEventListener('mouseenter', showMenu)
                item.addEventListener('mouseleave', hideMenu)
                subMenu.addEventListener('mouseenter', showMenu)
                subMenu.addEventListener('mouseleave', hideMenu)
            })
        }
        if (window.innerWidth < 1024) {
            const mobileMenuItems = document.querySelectorAll(".navigation-menu-catalog > li")

            mobileMenuItems.forEach(mobileItem => {
                mobileItem.addEventListener("click", function () {
                    console.log(mobileItem)
                    // mobileItem.querySelector("a").classList.toggle("header-hover-mobile")
                    let itemSubMenu = mobileItem.querySelector(".mobile-menu")
                    if (itemSubMenu) {
                        itemSubMenu.classList.toggle("d-block")

                    }
                })
            })
        }
        let defaultMenu = document.querySelector(".default-menu")
        if (defaultMenu) {
            if (window.innerWidth < 1024) {
                defaultMenu.classList.remove("default-menu")
            } else {
                defaultMenu.classList.add("default-menu")
            }
        }

        if (window.innerWidth < 1024) {
            const mobileMenuItem = document.querySelectorAll(".second-subMenu"),
                mobileParentSubMenu = document.querySelectorAll(".mobile-item")
            mobileParentSubMenu.forEach(item => {
                if (item.classList.contains("default-item")) {
                    item.classList.remove("default-item")
                }
            })
            mobileMenuItem.forEach(item => {
                if (item.classList.contains("default-menu")) {
                    item.classList.remove("default-menu")
                }
            })
            const mobileSubMenu = document.querySelectorAll(".mobile-item > a")
            mobileSubMenu.forEach(mobileItem => {
                mobileItem.addEventListener("click", function (e) {
                    e.preventDefault()
                    const mobileMenuItem = mobileItem.nextElementSibling
                    if (mobileMenuItem) {
                        mobileMenuItem.classList.toggle("d-block")
                    }
                })
            })
        }
        const subMenuItems = document.querySelectorAll('.item')
        subMenuItems.forEach((item) => {
            const subMenu = document.querySelector('.default-menu')
            item.addEventListener('mouseenter', function () {
                if (subMenu) {
                    subMenu.style.display = 'none'
                }
            })
            item.addEventListener('mouseleave', function () {
                if (subMenu) {
                    if (window.matchMedia('(min-width: 1024px)').matches) {
                        subMenu.style.display = 'flex'
                    } else {
                        subMenu.style.display = 'block'

                    }
                }
            })
        })
        if (document.querySelector("#burger")) {
            const burger = document.querySelector(".burger"),
                mobileMenu = document.querySelector(".navigation-menu-catalog"),
                sections = document.querySelectorAll(".scrollBurger"),
                cancelMenu = document.querySelector(".cancel-menu"),
                headList = document.querySelectorAll(".head-subMenu")

            let isMenuOpen = false
            headList.forEach(item => {
                item.addEventListener("click", function () {
                    let subSubmenu = item.nextElementSibling
                    console.log(item.nextElementSibling)
                    subSubmenu.classList.toggle("d-block")
                })
            })

            burger.addEventListener('click', function () {
                burger.classList.add('active')
                mobileMenu.style.overflowY = "scroll"
                mobileMenu.style.left = "0"
                mobileMenu.style.top = "-62px"
                blackFon.classList.add("black-fon-mobile")
                blackFon.style.left = "80%"
                isMenuOpen = true
            })

            window.addEventListener('scroll', function () {
                sections.forEach(section => {
                    const rect = section.getBoundingClientRect()

                    if (rect.top <= 0 && rect.bottom >= 0) {
                        burger.classList.remove('active')
                        closeMenu()
                        isMenuOpen = false
                    }
                })
            })
            cancelMenu.addEventListener("click", function () {
                closeMenu()
            })
            blackFon.addEventListener("click", function () {
                closeMenu()

            })

            function closeMenu() {
                burger.classList.remove('active')
                burger.classList.add("noactive")
                mobileMenu.style.left = "-100%"
                mobileMenu.style.top = "-62px"
                mobileMenu.style.overflowY = ""
                burger.style.left = "0"
                blackFon.classList.remove("black-fon-mobile")
                blackFon.style.left = "0"
            }
        }
    }
    //filter catalog mobile
    if (document.querySelector(".filter-btn-mobile")) {
        const filterMobileBtn = document.querySelector(".filter-btn-mobile"),
            filterMobile = document.querySelector(".filter"),
            cancelFilter = document.querySelector(".cancel-filter")

        filterMobileBtn.addEventListener("click", function (e) {
            e.preventDefault()
            // filterMobile.classList.add("filter-mobile-menu")
            filterMobile.style.left = "0"
            filterMobile.style.transition = "all .5s ease"
            blackFon.classList.add("black-fon-mobile")
            blackFon.style.left = "80%"
        })

        function closeFilter() {
            blackFon.classList.remove("black-fon-mobile")
            blackFon.style.left = "0"
            filterMobile.style.left = "-100%"
            filterMobile.style.transition = ""

        }
        cancelFilter.addEventListener("click", function (e) {
            // filterMobile.classList.remove("filter-mobile-menu")
            closeFilter()
        })
        blackFon.addEventListener("click", function () {
            closeFilter()

        })
    }
    //custom select
    if (document.querySelector(".sort-select")) {
        const selects = document.querySelectorAll('.select')

        selects.forEach(select => {
            const selectIn = select.querySelector('.select__in'),
                selectItems = select.querySelectorAll('.select__item'),
                thisInput = select.querySelector('.select__input'),
                event = new Event('change')

            selectIn.addEventListener('click', () => {
                selects.forEach(_select => {
                    if (_select !== select)
                        _select.classList.remove('is-opened')
                })
                select.classList.toggle('is-opened')
            })
            if (selectItems.length > 0) {
                const firstItem = selectItems[0]
                thisInput.value = firstItem.dataset.value
                // selectIn.innerHTML = firstItem.innerHTML
                firstItem.classList.add('is-active')
            }
            selectItems.forEach(item => {
                item.addEventListener('click', () => {
                    thisInput.value = item.dataset.value
                    thisInput.dispatchEvent(event)
                    selectIn.innerHTML = item.innerHTML
                    selectItems.forEach(_item => {
                        _item.classList.remove('is-active')
                    })
                    item.classList.add('is-active')
                    select.classList.remove('is-opened')
                })
            })
        })

        document.addEventListener('click', e => {
            if (!e.target.closest('.select')) {
                selects.forEach(select => {
                    if (select.classList.contains('is-opened'))
                        select.classList.remove('is-opened')
                })
            }
        })

        document.addEventListener('keyup', e => {
            if (e.key == 'Escape') {
                selects.forEach(select => {
                    if (select.classList.contains('is-opened'))
                        select.classList.remove('is-opened')
                })
            }
        })
    }
    //custom range
    if (document.querySelector('.slider-range')) {
        const slider = document.querySelector('.slider-range'),
            minHandle = document.querySelector('#min-handle'),
            maxHandle = document.querySelector('#max-handle'),
            range = document.querySelector('#range'),
            minPriceInput = document.querySelector('#min-price'),
            maxPriceInput = document.querySelector('#max-price'),
            minValueSpan = document.querySelector('#min-value'),
            maxValueSpan = document.querySelector('#max-value'),
            sliderWidth = slider.offsetWidth,
            handleWidth = minHandle.offsetWidth

        let minPrice = minValueSpan.getAttribute("data-value"),
            maxPrice = maxValueSpan.getAttribute("data-value")

        function updateRange() {
            const minPos = minHandle.offsetLeft,
                maxPos = maxHandle.offsetLeft

            range.style.left = minPos + 'px'
            range.style.width = (maxPos - minPos) + 'px'

            const minValue = Math.round(minPrice + (minPos / (sliderWidth - handleWidth)) * (maxPrice - minPrice)),
                maxValue = Math.round(minPrice + (maxPos / (sliderWidth - handleWidth)) * (maxPrice - minPrice))
            minPriceInput.value = minValue
            maxPriceInput.value = maxValue
            minValueSpan.textContent = minValue
            maxValueSpan.textContent = maxValue
        }

        function handleDrag(e, handle) {
            e.preventDefault()

            const handleStartX = e.clientX || e.touches[0].clientX
            const handleStartLeft = handle.offsetLeft

            const onMove = (moveEvent) => {
                const moveX = moveEvent.clientX || moveEvent.touches[0].clientX
                let newLeft = moveX - handleStartX + handleStartLeft

                if (handle === minHandle) {
                    newLeft = Math.max(0, Math.min(newLeft, maxHandle.offsetLeft - handleWidth))
                } else {
                    newLeft = Math.max(minHandle.offsetLeft + handleWidth, Math.min(newLeft, sliderWidth - handleWidth))
                }

                handle.style.left = newLeft + 'px'
                updateRange()
            }

            const onEnd = () => {
                document.removeEventListener('mousemove', onMove)
                document.removeEventListener('mouseup', onEnd)
                document.removeEventListener('touchmove', onMove)
                document.removeEventListener('touchend', onEnd)
            }

            document.addEventListener('mousemove', onMove)
            document.addEventListener('mouseup', onEnd)
            document.addEventListener('touchmove', onMove)
            document.addEventListener('touchend', onEnd)
        }

        minHandle.addEventListener('mousedown', (e) => handleDrag(e, minHandle))
        maxHandle.addEventListener('mousedown', (e) => handleDrag(e, maxHandle))
        minHandle.addEventListener('touchstart', (e) => handleDrag(e, minHandle))
        maxHandle.addEventListener('touchstart', (e) => handleDrag(e, maxHandle))

        updateRange()

    }
    // випадаючі категорії в каталозі
    function toggleVisibility(buttons, visibleClass, activeClass) {
        buttons.forEach((item) => {
            item.addEventListener("click", function (e) {
                e.preventDefault()
                const descriptionMore = item.nextElementSibling
                descriptionMore.classList.toggle(visibleClass)
                item.classList.toggle(activeClass)
            })
        })
    }

    const btnReadMore = document.querySelectorAll(".readmore"),
        menuReadMore = document.querySelectorAll(".readmore-menu"),
        menuReadMoreMain = document.querySelectorAll(".readmore-menu-main")

    toggleVisibility(btnReadMore, "visible", "readmore-active")
    toggleVisibility(menuReadMore, "visible-menu", "readmore-active-menu")
    toggleVisibility(menuReadMoreMain, "visible-menu", "readmore-active-menu-main")

    //mobile slider
    if (window.innerWidth < 1024 && document.querySelector(".btn-slider")) {
        const imageItems = document.querySelectorAll(".image-for-slider"),
            imgSliderBlock = document.querySelector(".img-slider"),
            btnSlider = document.querySelector(".btn-slider")

        imageItems.forEach((imgItem, index) => {
            let sliderImageItem = document.createElement("img"),
                inputSliderRadio = document.createElement("input")

            inputSliderRadio.type = "radio"
            inputSliderRadio.name = "slider-radio"
            inputSliderRadio.id = `slider-radio-${index}`
            if (index === 0) inputSliderRadio.checked = true

            sliderImageItem.src = imgItem.src
            sliderImageItem.classList.add("mobile-slider")
            if (index === 0) sliderImageItem.classList.add("active")

            imgSliderBlock.appendChild(sliderImageItem)
            btnSlider.appendChild(inputSliderRadio)
        })

        const radioButtons = document.querySelectorAll('input[name="slider-radio"]'),
            comments = document.querySelectorAll('.mobile-slider')
        let currentIndexRadio = 0

        function switchComment(index) {
            radioButtons[index].checked = true
            comments.forEach((comment) => {
                comment.classList.remove('active')
            })
            comments[index].classList.add('active')
            currentIndexRadio = index
        }

        radioButtons.forEach((radioButton, index) => {
            radioButton.addEventListener('change', () => {
                switchComment(index)
            })
        })

        imgSliderBlock.addEventListener('touchstart', handleTouchStart, false)
        imgSliderBlock.addEventListener('touchmove', handleTouchMove, false)

        let x1 = null

        function handleTouchStart(evt) {
            const firstTouch = evt.touches[0]
            x1 = firstTouch.clientX
        }

        function handleTouchMove(evt) {
            if (!x1) {
                return false
            }

            let x2 = evt.touches[0].clientX
            let xDiff = x2 - x1

            if (xDiff > 0) {
                currentIndexRadio = (currentIndexRadio - 1 + radioButtons.length) % radioButtons.length
            } else {
                currentIndexRadio = (currentIndexRadio + 1) % radioButtons.length
            }

            switchComment(currentIndexRadio)

            x1 = null
        }
    }

    //slider fow window width > 1024
    function slider() {
        const sliderContainer = document.querySelector('.carousel-card'),
            sliderImages = [...document.querySelectorAll('.carousel-item')],
            btnSlider = document.querySelectorAll(".btn")

        let imageHeight = sliderImages[0].offsetHeight

        let currentSlide = 0
        btnSlider.forEach(itemBtn => {
            if (sliderImages.length > 3) {
                itemBtn.style.display = "block"
            } else {
                itemBtn.style.display = "none"
            }
        })

        function nextSlide(e) {
            e.preventDefault()
            if (currentSlide > 0) {
                currentSlide--
                sliderContainer.style.transition = 'transform 0.3s ease-in-out'
                sliderContainer.style.transform = `translateY(-${currentSlide * imageHeight}px)`
            }
        }

        function prevSlide(e) {
            e.preventDefault()
            if (currentSlide < sliderImages.length - 3) {
                currentSlide++
                sliderContainer.style.transition = 'transform 0.3s ease-in-out'
                sliderContainer.style.transform = `translateY(-${currentSlide * imageHeight}px)`
            }
        }

        const nextButton = document.querySelector('.btn-next')
        if (nextButton) {
            nextButton.addEventListener('click', nextSlide)
        }

        const prevButton = document.querySelector('.btn-prev')
        if (prevButton) {
            prevButton.addEventListener('click', prevSlide)
        }

    }
    if (document.querySelector(".img-block")) {
        slider()
        window.addEventListener('resize', () => {
            slider()
        })
    }
    //btn fow card block haracteristic window width > 1024
    if (document.querySelector("#delivery") && window.innerWidth >= 1024) {
        const buttons = document.querySelectorAll('.transparent-cta'),
            sections = document.querySelectorAll('.description-product, .haracteristic-block, .comment-card, .delivery-card')

        function hideAllSections() {
            sections.forEach(section => section.classList.remove('active'))
        }

        function deactivateAllButtons() {
            buttons.forEach(button => button.classList.remove('active'))
        }

        buttons.forEach(button => {
            button.addEventListener('click', function (event) {
                event.preventDefault()
                const target = button.getAttribute('data-target')

                hideAllSections()
                deactivateAllButtons()

                const sectionToShow = document.getElementById(target)
                if (sectionToShow) {
                    sectionToShow.classList.add('active')
                    button.classList.add('active')
                }
            })
        })

        hideAllSections()
        deactivateAllButtons()
        document.querySelector('.description-product').classList.add('active')
        document.querySelector('[data-target="about"]').classList.add('active')
    }
    //popup size card
    if (document.querySelector(".popup-size-cta")) {
        const popupSize = document.querySelector(".popup-size-cta"),
            blackFonPOpup = document.querySelector(".black-fon-popup-size"),
            tablePopup = document.querySelector(".size-table-popup"),
            cancelPopupSize = document.querySelector(".cancel-size-popup")
        popupSize.addEventListener("click", function () {
            tablePopup.style.display = "block"
            if (window.innerWidth >= 1024) {
                blackFonPOpup.classList.add("black-fon-style")
            } else {
                blackFonPOpup.classList.add("black-fon-mobile")
            }

        })

        function cancelSizePopup() {
            if (window.innerWidth >= 1024) {
                blackFonPOpup.classList.remove("black-fon-style")
            } else {
                blackFonPOpup.classList.remove("black-fon-mobile")
            }
            tablePopup.style.display = "none"
            body.style.height = ""
            body.style.overflow = ""
        }
        cancelPopupSize.addEventListener("click", function () {
            cancelSizePopup()
        })
        blackFonPOpup.addEventListener("click", function () {
            cancelSizePopup()
        })
    }

    //popup registration-enter
    const cabinetCta = document.querySelectorAll(".cabinet-cta"),
        blackFonReg = document.querySelector(".black-fon-popup"),
        popupCabinet = document.querySelector(".popup-cabinet"),
        cancelCabinetPopup = document.querySelector(".cancel-popup-cabinet"),
        eyeReg = document.querySelectorAll(".eye"),
        navigationMenuPopup = document.querySelector(".navigation-menu-catalog");

    let isAuthenticated = document.getElementById('auth-status').dataset.authenticated === 'true';

    cabinetCta.forEach(itemCta => {
        if (!isAuthenticated) {
            itemCta.addEventListener("click", function (e) {
                e.preventDefault();
                popupCabinet.style.display = "block";
                blackFonReg.style.display = "block";
                navigationMenuPopup.style.zIndex = "20";
            });
        }
    });

    if (cancelCabinetPopup) {
        cancelCabinetPopup.addEventListener("click", function (e) {
            e.preventDefault();
            popupCabinet.style.display = "none";
            blackFonReg.style.display = "none";
            navigationMenuPopup.style.zIndex = "30";
        });
    }

    // visible password
    eyeReg.forEach(eye => {
        eye.addEventListener('click', function (e) {
            e.preventDefault()
            const target = document.getElementById(this.getAttribute('data-target')),
                targerEye = this.querySelector("svg")
            if (target.type === 'password') {
                target.type = 'text'
                targerEye.style.display = "block"
                eye.classList.remove("closeEye")
            } else {
                target.type = 'password'
                targerEye.style.display = "none"
                eye.classList.add("closeEye")
            }
        })
    })
    const entryLink = document.querySelector('.d-flex.item-center.cta-reg .entry'),
        registrationLink = document.querySelector('.d-flex.item-center.cta-reg .registration'),
        entryForm = document.querySelector('.entry-form'),
        registrationForm = document.querySelector('.registration-form')

    entryLink.addEventListener('click', function () {
        entryLink.classList.add('active-link')
        registrationLink.classList.remove('active-link')
        entryForm.classList.add('active-form')
        registrationForm.classList.remove('active-form')
    })

    registrationLink.addEventListener('click', function () {
        registrationLink.classList.add('active-link')
        entryLink.classList.remove('active-link')
        registrationForm.classList.add('active-form')
        entryForm.classList.remove('active-form')
    })
    // page with help information - navigation
    if (document.querySelector(".menu-help-item ")) {
        const ctaHelp = document.querySelectorAll(".menu-help-item a")

        ctaHelp.forEach(helpItem => {
            helpItem.addEventListener("mouseenter", function () {
                helpItem.classList.add("hover-cta-help")
            })
            helpItem.addEventListener("mouseleave", function () {
                helpItem.classList.remove("hover-cta-help")
            })
        })


    }
    if (document.querySelector('.help-content') && window.innerWidth >= 1024) {
        const menuItems = document.querySelectorAll('.menu-help-item a'),
            contentSections = document.querySelectorAll('.help-content')

        function activateSection(target) {
            menuItems.forEach(i => i.classList.remove('active-cta-help'))

            const activeItem = Array.from(menuItems).find(i => i.getAttribute('data-href') === target)
            if (activeItem) {
                activeItem.classList.add('active-cta-help')
            }

            contentSections.forEach(section => {
                section.style.display = 'none'
                section.classList.remove('active-help')
            })

            const targetSection = document.getElementById(target)
            if (targetSection) {
                targetSection.style.display = 'block'
                targetSection.classList.add('active-help')
            }
        }

        if (menuItems.length > 0) {
            menuItems.forEach(item => {
                item.addEventListener('click', function (event) {
                    event.preventDefault()
                    const target = this.getAttribute('data-href')
                    activateSection(target)
                    history.pushState(null, '', `#${target}`)
                })
            })

            const hash = window.location.hash.substring(1)
            if (hash) {
                activateSection(hash)
            } else {
                const initialSection = document.getElementById(menuItems[0].getAttribute('data-href'))
                if (initialSection) {
                    initialSection.style.display = 'block'
                    initialSection.classList.add('active-help')
                }
            }

            window.addEventListener('hashchange', function () {
                const newHash = window.location.hash.substring(1)
                activateSection(newHash)
            })
        }

    }

    if (document.querySelector("#ukrPostRadio")) {
        const ukrPoshta = document.querySelector('#ukrPoshta'),
            novaPoshta = document.querySelector('#novaPoshta'),
            meest = document.querySelector('#meest'),
            deliveryOptions = document.querySelector('.post-radio'),
            cityVilageOptions = document.querySelector('#cityVilageOptions'),
            forCity = document.querySelector('#forCityAdress'),
            forCityViddilenia = document.querySelector('#forCityViddilenia'),
            forVilage = document.querySelector('#forVilage'),
            poshtomatOption = document.querySelector('#postomatOption'),
            forPostomat = document.querySelector('#forPostomat'),
            deliveryRadios = document.querySelectorAll('input[name="adress"]'),
            cityVilageRadios = document.querySelectorAll('input[name="cityVilage"]'),
            ukrPostRadio = document.querySelector("#ukrPostRadio"),
            noveMeestRadio = document.querySelector("#novaPostMeest")

        deliveryOptions.style.display = 'none'
        cityVilageOptions.style.display = 'none'
        forCity.style.display = 'none'
        forCityViddilenia.style.display = 'none'
        forVilage.style.display = 'none'
        forPostomat.style.display = 'none'
        poshtomatOption.style.display = 'none'
        noveMeestRadio.style.display = "none"
        ukrPostRadio.style.display = "none"

        function showDeliveryOptions() {
            if (ukrPoshta.checked || novaPoshta.checked || meest.checked) {
                deliveryOptions.style.display = 'flex'
                if (meest.checked) {
                    poshtomatOption.style.display = 'none'
                    if (document.querySelector('#poshtomat').checked) {
                        document.querySelector('#poshtomat').checked = false
                    }
                } else {
                    poshtomatOption.style.display = 'flex'
                }
            } else {
                deliveryOptions.style.display = 'none'
                cityVilageOptions.style.display = 'none'
                forCity.style.display = 'none'
                forCityViddilenia.style.display = 'none'
                forVilage.style.display = 'none'
                forPostomat.style.display = 'none'
            }
            if (ukrPoshta.checked) {
                ukrPostRadio.style.display = "flex"
                noveMeestRadio.style.display = "none"
            } else {
                ukrPostRadio.style.display = "none"
                // noveMeestRadio.style.display = "flex"
            }
        }

        function showCityVilageOptions() {
            if (document.querySelector('#viddilenia').checked || document.querySelector('#adress').checked || document.querySelector('#poshtomat').checked || document.querySelector('#viddileniaExpres').checked || document.querySelector('#viddileniaUkr').checked || document.querySelector('#curierExpres').checked || document.querySelector('#curierUkr').checked) {
                cityVilageOptions.style.display = 'flex'
            } else {
                cityVilageOptions.style.display = 'none'
                forCity.style.display = 'none'
                forCityViddilenia.style.display = 'none'
                forVilage.style.display = 'none'
                forPostomat.style.display = 'none'
            }
        }

        function showCityOrVilageForm() {
            forCity.style.display = 'none'
            forCityViddilenia.style.display = 'none'
            forVilage.style.display = 'none'
            forPostomat.style.display = 'none'

            if (document.querySelector('#viddilenia').checked || document.querySelector('#viddileniaExpres').checked || document.querySelector('#viddileniaExpres').checked || document.querySelector('#viddileniaUkr').checked || document.querySelector('#curierExpres').checked || document.querySelector('#curierUkr').checked) {
                if (document.querySelector('#city').checked) {
                    forCityViddilenia.style.display = 'block'
                } else if (document.querySelector('#vilage').checked) {
                    forVilage.style.display = 'block'
                }
            } else if (document.querySelector('#adress').checked) {
                if (document.querySelector('#city').checked) {
                    forCity.style.display = 'block'
                } else if (document.querySelector('#vilage').checked) {
                    forVilage.style.display = 'block'
                }
            } else if (document.querySelector('#poshtomat').checked) {
                forPostomat.style.display = 'block'
            }
        }

        ukrPoshta.addEventListener('change', () => {
            showDeliveryOptions()
            showCityVilageOptions()
            showCityOrVilageForm()
        })
        novaPoshta.addEventListener('change', () => {
            showDeliveryOptions()
            showCityVilageOptions()
            showCityOrVilageForm()
        })
        meest.addEventListener('change', () => {
            showDeliveryOptions()
            showCityVilageOptions()
            showCityOrVilageForm()
        })

        deliveryRadios.forEach(radio => {
            radio.addEventListener('change', () => {
                showCityVilageOptions()
                showCityOrVilageForm()
            })
        })

        cityVilageRadios.forEach(radio => {
            radio.addEventListener('change', showCityOrVilageForm)
        })

        showDeliveryOptions()
        showCityVilageOptions()
        showCityOrVilageForm()
    }
    if (document.querySelector('.cabinet-top-prodaz')) {
        const topProdazMain = document.querySelector('.top-prodaz-main.cabinet-top-prodaz'),
            descriptionAboutUs = document.querySelector('.cabinet-cart-product'),
            originalParent = topProdazMain.parentElement,
            originalNextSibling = topProdazMain.nextElementSibling

        function moveTopProdazMain() {
            if (window.innerWidth <= 1024) {
                if (topProdazMain && topProdazMain.parentElement !== descriptionAboutUs) {
                    descriptionAboutUs.appendChild(topProdazMain)
                }
            } else {
                originalParent.appendChild(topProdazMain)
            }
        }

        moveTopProdazMain()
        window.addEventListener('resize', moveTopProdazMain)

    }
    if (document.querySelector('#userPhone')) {
        const phoneInput = document.querySelector('#userPhone')

        phoneInput.addEventListener('input', function () {
            let phoneNumber = phoneInput.value.trim()
            const mask = "+380"

            if (!phoneNumber.startsWith(mask)) {
                phoneNumber = mask + phoneNumber
            }

            let cleanedValue = phoneNumber.replace(/[^\d+]/g, "")

            if (cleanedValue.length > 13) {
                cleanedValue = cleanedValue.slice(0, 13)
            }

            const validInput = isValidPhoneNumber(cleanedValue)

            if (validInput && cleanedValue.length === 13) {
                phoneInput.style.borderColor = 'green'
            } else {
                phoneInput.style.borderColor = 'red'
            }
        })
    }


    function isValidPhoneNumber(phoneNumber) {
        return /^\+?(\d{2})?([(]?\d{3}[)]?)\s?[-]?\s?(?:\d{3})\s?[-]?(?:\s?\d{2})\s?[-]?(?:\s?\d{2})$/.test(phoneNumber)
    }
    const inputMasks = document.querySelectorAll(".inputMask")

    inputMasks.forEach(function (inputMask) {
        inputMask.addEventListener("click", function () {
            if (!inputMask.value) {
                inputMask.value = "+380";
            }
        })

        inputMask.addEventListener("input", function () {
            let inputValue = inputMask.value;
            let cleanedValue = inputValue.replace(/[^\d+]/g, "")

            inputMask.value = cleanedValue

            if (cleanedValue.length > 13) {
                inputMask.value = cleanedValue.slice(0, 13)
            }

            if (!cleanedValue.startsWith("+380")) {
                inputMask.value = "+380" + cleanedValue.slice(3)
            }
        })
    })
})
