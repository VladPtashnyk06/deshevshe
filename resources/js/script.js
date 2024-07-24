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
            handleWidth = minHandle.offsetWidth;
    
        let minPrice = parseFloat(minValueSpan.getAttribute("data-value")),
            maxPrice = parseFloat(maxValueSpan.getAttribute("data-value"))
    
        function updateRange() {
            const minPos = minHandle.offsetLeft,
                maxPos = maxHandle.offsetLeft;
    
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
    
            const handleStartX = e.clientX || e.touches[0].clientX,
                handleStartLeft = handle.offsetLeft
    
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
            radioNovaPoshta = document.querySelector("#novaPost"),
            radioUkrPoshta = document.querySelector("#ukrPostRadio"),
            radioMeest = document.querySelector("#meestPostRadioBtn"),
            deliveryContainerCityVilage = document.querySelector("#delivery_location_type_container"),
            formContainer = document.querySelector(".form-order-container")
    
        const hideAllForms = () => {
            [radioMeest, radioUkrPoshta, radioNovaPoshta, deliveryContainerCityVilage, formContainer].forEach(el => el.style.display = "none")
        }
    
        const resetRadioButtons = () => {
            document.querySelectorAll('input[name="delivery_location_type"]').forEach(radio => radio.checked = false)
        }
    
        const showForm = (radioElement) => {
            hideAllForms()
            resetRadioButtons()
            radioElement.style.display = "flex"
            radioElement.querySelectorAll("input[name='delivery_type']").forEach(radioItem => {
                radioItem.addEventListener("change", function() {
                    deliveryContainerCityVilage.style.display = "flex"
                    deliveryContainerCityVilage.querySelectorAll("input").forEach(itemDelivery => {
                        itemDelivery.addEventListener("input", function() {
                            if(radioElement == radioNovaPoshta) {
                                formContainer.style.display = "block"
                            } else {
                                formContainer.style.display = "grid"
                            }
                        })
                    })
                })
            })
        }
    
        hideAllForms()
    
        ukrPoshta.addEventListener("change", function() {
            showForm(radioUkrPoshta)
        })
    
        novaPoshta.addEventListener("change", function() {
            showForm(radioNovaPoshta)
    
            const poshtomat = document.querySelector("#poshtomat")
            poshtomat.addEventListener("click", function() {
                deliveryContainerCityVilage.querySelector(".village-block").style.display = "none"
            })
    
            radioNovaPoshta.querySelectorAll("input[name='delivery_type']").forEach(radioItem => {
                radioItem.addEventListener("change", function() {
                    if (radioItem.id !== "poshtomat") {
                        deliveryContainerCityVilage.querySelector(".village-block").style.display = "flex"
                    }
                })
            })
        })
    
        meest.addEventListener("change", function() {
            hideAllForms()
            resetRadioButtons()
            radioMeest.style.display = "flex"
            radioMeest.querySelectorAll("input[name='delivery_type']").forEach(radioItem => {
                radioItem.addEventListener("change", function() {
                    deliveryContainerCityVilage.style.display = "none"
                    formContainer.style.display = "block"
                })
            })
        })
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
                inputMask.value = "+380"
            }
        })

        inputMask.addEventListener("input", function () {
            let inputValue = inputMask.value
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

    const RegistrationCheckbox = document.getElementById('registration');
    const PasswordFields = document.getElementById('password_fields');
    const PhoneInput = document.getElementById('user_phone');

    if (RegistrationCheckbox) {
        RegistrationCheckbox.addEventListener('change', function() {
            if (this.checked) {
                PasswordFields.classList.remove('d-none');
            } else {
                PasswordFields.classList.add('d-none');
            }
        });
    }


    const Region = document.getElementById('region');
    const CityName = document.getElementById('city_name');
    const BranchNumber = document.getElementById('branch_number');
    const CityRefHidden = document.getElementById('city_ref');
    const BranchRefHidden = document.getElementById('branch_ref');
    const MeestContainer = document.getElementById('meest_container');
    const MeestBranchesContainer = document.getElementById('meest_branch_div');
    const MeestRegionSelect = document.getElementById('meest_region_ref');
    const MeestCityInput = document.getElementById('meest_city_input');
    const MeestBranchesInput = document.getElementById('meest_branches_input');
    const MeestCityList = document.getElementById('meest_city_list');
    const MeestBranchesList = document.getElementById('meest_branches_list');
    const MeestCityhDiv = document.getElementById('meest_city_div');
    const MeestCityBranchDiv = document.getElementById('meest_branch_div');
    const NovaPoshtaContainer = document.getElementById('nova_poshta_container');
    const NovaPoshtaRegionSelect = document.getElementById('nova_poshta_region_ref');
    const NovaPoshtaBranchDiv = document.getElementById('nova_poshta_branch_div');
    const NovaPoshtaCityDiv = document.getElementById('nova_poshta_city_div');
    const NovaPoshtaCityInput = document.getElementById('nova_poshta_city_input');
    const NovaPoshtaBranchesInput = document.getElementById('nova_poshta_branches_input');
    const NovaPoshtaCityBranchContainer = document.getElementById('nova_postha_city_and_branch');
    const NovaPoshtaCityList = document.getElementById('nova_poshta_city_list');
    const NovaPoshtaBranchesList = document.getElementById('nova_poshta_branches_list');
    const UkrPoshtaBranchDiv = document.getElementById('ukr_poshta_branch_div');
    const UkrPoshtaCityDiv = document.getElementById('ukr_poshta_city_div');
    const UkrPoshtaRegionSelect = document.getElementById('ukr_poshta_region_ref');
    const UkrPoshtaCityInput = document.getElementById('ukr_poshta_city_input');
    const UkrPoshtaBranchesInput = document.getElementById('ukr_poshta_branches_input');
    const UkrPoshtaCityList = document.getElementById('ukr_poshta_city_list');
    const UkrPoshtaBranchesList = document.getElementById('ukr_poshta_branches_list');
    const AddressContainerStreet = document.getElementById('address_container-street');
    const AddressContainerBuild = document.getElementById('address_container-build');
    const AddressContainerKv = document.getElementById('address_container-kv');
    const DeliveryTypeInputs = document.querySelectorAll('input[name="delivery_type"]');
    const DeliveryLocationTypeRadios = document.querySelectorAll('input[name="delivery_location_type"]');
    const DeliveryLocationVillage = document.getElementById('delivery_location_village');
    const DeliveryLocationVillageDistrict = document.getElementById('delivery_location_village-district');
    const DeliveryLocationVillageRef = document.getElementById('delivery_location_village-ref');
    const StreetInput = document.getElementById('street_input');
    const StreetList = document.getElementById('street_list');
    const StreetRef = document.getElementById('street_ref');
    const DistrictInput = document.getElementById('district_input');
    const DistrictList = document.getElementById('district_list');
    const DistrictRef = document.getElementById('district_ref');
    const VillageInput = document.getElementById('village_input');
    const VillageList = document.getElementById('village_list');
    const VillageRef = document.getElementById('village_ref');
    const House = document.getElementById('house');
    const Flat = document.getElementById('flat');

    NovaPoshtaRegionSelect.addEventListener('change', function() {
        NovaPoshtaCityInput.value = '';
        CityRefHidden.value = '';
        BranchRefHidden.value = '';
        NovaPoshtaBranchesInput.value = '';
        NovaPoshtaCityList.innerHTML = '';
        NovaPoshtaBranchesList.innerHTML = '';
        StreetInput.value = '';
        StreetList.value = '';
        StreetRef.value = '';
        DistrictInput.value = '';
        DistrictList.value = '';
        DistrictRef.value = '';
        VillageInput.value = '';
        VillageList.value = '';
        VillageRef.value = '';
        CityName.value = '';
        House.value = '';
        Flat.value = '';
    });
    MeestRegionSelect.addEventListener('change', function() {
        MeestCityInput.value = '';
        MeestBranchesInput.value = '';
        MeestCityList.innerHTML = '';
        MeestBranchesList.innerHTML = '';
    });
    UkrPoshtaRegionSelect.addEventListener('change', function () {
        UkrPoshtaCityInput.value = '';
        UkrPoshtaBranchesInput.value = '';
        UkrPoshtaCityList.innerHTML = '';
        UkrPoshtaBranchesList.innerHTML = '';
        StreetInput.value = '';
        StreetList.value = '';
        StreetRef.value = '';
        DistrictInput.value = '';
        DistrictList.value = '';
        DistrictRef.value = '';
        VillageInput.value = '';
        VillageList.value = '';
        VillageRef.value = '';
        CityName.value = '';
        House.value = '';
        Flat.value = '';
    })

    document.addEventListener('click', function(event) {
        const isClickInsideDistrictList = DistrictList.contains(event.target) || event.target === DistrictInput;
        const isClickInsideVillageList = VillageList.contains(event.target) || event.target === VillageInput;
        const isClickInsideStreetList = StreetList.contains(event.target) || event.target === StreetInput;

        if (!isClickInsideDistrictList) {
            DistrictList.classList.add('d-none');
        }

        if (!isClickInsideVillageList) {
            VillageList.classList.add('d-none');
        }

        if (!isClickInsideStreetList) {
            StreetList.classList.add('d-none');
        }
    });
    let type
    function setType() {
        DeliveryLocationTypeRadios.forEach(radio => {
            if (radio.checked) {
                if (radio.value === 'City') {
                    type = radio.value;
                    CityRefHidden.value = '';
                    CityName.value = '';
                    BranchRefHidden.value = '';
                    BranchNumber.value = '';
                    NovaPoshtaBranchesInput.value = '';
                    NovaPoshtaBranchesList.innerHTML = '';
                    UkrPoshtaCityInput.value = '';
                    UkrPoshtaCityList.innerHTML = '';
                    UkrPoshtaBranchesInput.value = '';
                    UkrPoshtaBranchesList.innerHTML = '';
                    DistrictInput.value = '';
                    DistrictList.value = '';
                    DistrictRef.value = '';
                    VillageInput.value = '';
                    VillageList.value = '';
                    VillageRef.value = '';
                    StreetInput.value = '';
                    StreetList.value = '';
                    StreetRef.value = '';
                    House.value = '';
                    Flat.value = '';
                } else if (radio.value === 'Village') {
                    type = radio.value;
                    CityRefHidden.value = '';
                    CityName.value = '';
                    NovaPoshtaCityInput.value = '';
                    NovaPoshtaCityList.innerHTML = '';
                    BranchRefHidden.value = '';
                    BranchNumber.value = '';
                    NovaPoshtaBranchesInput.value = '';
                    NovaPoshtaBranchesList.innerHTML = '';
                    UkrPoshtaCityInput.value = '';
                    UkrPoshtaCityList.innerHTML = '';
                    UkrPoshtaBranchesInput.value = '';
                    UkrPoshtaBranchesList.innerHTML = '';
                    DistrictInput.value = '';
                    DistrictList.value = '';
                    DistrictRef.value = '';
                    StreetInput.value = '';
                    StreetList.value = '';
                    StreetRef.value = '';
                    House.value = '';
                    Flat.value = '';
                }
            }
        });
    }

    let currentInputHandler = null;
    let currentFocusHandler = null;

    updateFormVisibility() 

    DeliveryTypeInputs.forEach(input => {
        input.addEventListener('change', updateFormVisibility)
    })

    setType()
    DeliveryLocationTypeRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            setType()
            updateFormVisibility(type)
        })
    })
    document.querySelectorAll('input[name="delivery_type"]').forEach((radio) => {
        radio.addEventListener('change', (event) => {
            handleDeliveryTypeChange(event)
        })
    })
    
    document.querySelectorAll('input[name="delivery_location_type"]').forEach((radio) => {
        radio.addEventListener('change', (event) => {
            handleLocationTypeChange(event)
        })
    })
    
    function handleDeliveryTypeChange(event) {
        let selectedDeliveryType = event.target.value,
            poshtaAndDelivery = selectedDeliveryType.split("_"),
            poshta = poshtaAndDelivery[0],
            delivery = poshtaAndDelivery[1],
            selectedRadio = Array.from(document.querySelectorAll('input[name="delivery_location_type"]')).find(radio => radio.checked)
        if (selectedRadio) {
            type = selectedRadio.value
        }
        updateFormVisibility(poshta, delivery, type)
    }
    
    function handleLocationTypeChange(event) {
        let selectedRadio = event.target
        if (selectedRadio) {
            type = selectedRadio.value
        }
        let selectedDeliveryType = Array.from(document.querySelectorAll('input[name="delivery_type"]')).find(radio => radio.checked)
            let poshtaAndDelivery = selectedDeliveryType.value.split("_"),
                poshta = poshtaAndDelivery[0],
                delivery = poshtaAndDelivery[1]
            updateFormVisibility(poshta, delivery, type)
    }
    function updateFormVisibility(poshta, delivery, type) {
        
        const inputCategoryOfWarehouse = document.getElementById('categoryOfWarehouse');
        NovaPoshtaBranchesInput.value = '';
        NovaPoshtaCityInput.value = '';
        MeestBranchesInput.value = '';
        MeestCityInput.value = '';
        NovaPoshtaBranchesList.innerHTML = '';
        MeestBranchesList.innerHTML = '';
        MeestCityList.innerHTML = '';
        BranchRefHidden.value = '';

        if (currentInputHandler) {
            StreetInput.removeEventListener('input', currentInputHandler);
        }
        if (currentFocusHandler) {
            StreetInput.removeEventListener('focus', currentFocusHandler);
        }

        DeliveryLocationTypeRadios.forEach(radio => {
            if (radio.checked) {
                if (type === 'City') {
                    currentInputHandler = function() {
                        if (poshta === 'NovaPoshta') {
                            const searchText = this.value.trim().toLowerCase();
                            if (CityName.value && searchText.length >= 0) {
                                NovaPoshtaFetchStreets(CityName.value, searchText);
                            } else {
                                StreetList.innerHTML = '';
                                StreetList.classList.add('d-none');
                            }
                        } else if (poshta === 'UkrPoshta') {
                            let cityId;
                            if (type === 'City') {
                                cityId = CityRefHidden.value;
                            } else if (type === 'Village') {
                                cityId = VillageRef.value;
                            }
                            const searchText = this.value.trim().toLowerCase();
                            if (cityId && searchText.length >= 0) {
                                fetchStreets(cityId, searchText);
                            } else {
                                VillageList.innerHTML = '';
                                VillageList.classList.add('d-none');
                            }
                        }
                    };

                    currentFocusHandler = function() {
                        if (poshta === 'NovaPoshta') {
                            if (StreetInput.value.trim().length === 0) {
                                NovaPoshtaFetchStreets(CityName.value, '');
                            } else if (StreetList.children.length > 0) {
                                StreetList.classList.remove('d-none');
                            }
                        } else if (poshta === 'UkrPoshta') {
                            let cityId;
                            if (type === 'City') {
                                cityId = CityRefHidden.value;
                            } else if (type === 'Village') {
                                cityId = VillageRef.value;
                            }
                            if (VillageInput.value.trim().length === 0) {
                                fetchStreets(cityId, '');
                            } else if (VillageList.children.length > 0) {
                                VillageList.classList.remove('d-none');
                            }
                        }
                    };

                    StreetInput.addEventListener('input', currentInputHandler);
                    StreetInput.addEventListener('focus', currentFocusHandler);
                }
            }
        });

        if (currentInputHandler) {
            VillageInput.removeEventListener('input', currentInputHandler);
        }
        if (currentFocusHandler) {
            VillageInput.removeEventListener('focus', currentFocusHandler);
        }

        DeliveryLocationTypeRadios.forEach(radio => {
            if (radio.checked) {
                if (type === 'Village') {
                    currentInputHandler = function() {
                        if (poshta === 'NovaPoshta') {
                            const districtRef = DistrictRef.value;
                            const searchText = this.value.trim().toLowerCase();
                            if (districtRef && searchText.length >= 0) {
                                NovaPoshtaFetchVillages(districtRef, searchText);
                            } else {
                                VillageList.innerHTML = '';
                                VillageList.classList.add('d-none');
                            }
                        } else if (poshta === 'UkrPoshta') {
                            const districtId = DistrictRef.value;
                            const searchText = this.value.trim().toLowerCase();
                            if (districtId && searchText.length >= 0) {
                                fetchCities(districtId, '', searchText);
                            } else {
                                VillageList.innerHTML = '';
                                VillageList.classList.add('d-none');
                            }
                        }
                    };

                    currentFocusHandler = function() {
                        if (poshta === 'NovaPoshta') {
                            const districtRef = DistrictRef.value;
                            if (VillageInput.value.trim().length === 0) {
                                NovaPoshtaFetchVillages(districtRef, '');
                            } else if (VillageList.children.length > 0) {
                                VillageList.classList.remove('d-none');
                            }
                        } else if (poshta === 'UkrPoshta') {
                            const districtId = DistrictRef.value;
                            if (VillageInput.value.trim().length === 0) {
                                fetchCities(districtId, '', '');
                            } else if (VillageList.children.length > 0) {
                                VillageList.classList.remove('d-none');
                            }
                        }
                    };

                    VillageInput.addEventListener('input', currentInputHandler);
                    VillageInput.addEventListener('focus', currentFocusHandler);
                }
            }
        });

        if (poshta === 'NovaPoshta') {
            const showCityElements = () => {
                NovaPoshtaBranchDiv.style.display = 'grid'
                NovaPoshtaCityDiv.style.display = 'grid'
                DeliveryLocationVillageDistrict.style.display = 'none'
                DeliveryLocationVillageRef.style.display = 'none'
            }
        
            const showVillageElements = () => {
                NovaPoshtaBranchDiv.style.display = 'grid'
                NovaPoshtaCityDiv.style.display = 'none'
                DeliveryLocationVillageDistrict.style.display = 'block'
                DeliveryLocationVillageRef.style.display = 'block'
                const parentElement = NovaPoshtaBranchDiv.parentNode
                parentElement.insertBefore(DeliveryLocationVillageDistrict, NovaPoshtaBranchDiv)
                parentElement.insertBefore(DeliveryLocationVillageRef, NovaPoshtaBranchDiv);
            }
        
            NovaPoshtaContainer.classList.remove('d-none')
            NovaPoshtaContainer.style.display = 'grid'
            NovaPoshtaCityBranchContainer.style.display = 'grid'
            MeestContainer.classList.add('d-none')
            UkrPoshtaCityDiv.classList.add('d-none')
            UkrPoshtaBranchDiv.classList.add('d-none')
            UkrPoshtaRegionSelect.classList.add('d-none')
            NovaPoshtaBranchDiv.style.display = 'grid'
            AddressContainerStreet.style.display = 'none'
            AddressContainerBuild.style.display = 'none'
            AddressContainerKv.style.display = 'none'
            NovaPoshtaCityDiv.style.display = 'grid'
            DeliveryLocationVillageDistrict.style.display = 'none'
            DeliveryLocationVillageRef.style.display = 'none'
            NovaPoshtaBranchesInput.placeholder = 'Введіть назву відділення'
            inputCategoryOfWarehouse.value = 'Branch'
        
            if (delivery === 'branch') {
                document.querySelector('#nova_poshta_branch_div label').textContent = 'Відділення Нової Пошти *'
                type === 'City' ? showCityElements() : showVillageElements()
            } else if (delivery === 'postomat') {
                AddressContainerStreet.style.display = 'none'
                AddressContainerBuild.style.display = 'none'
                AddressContainerKv.style.display = 'none'
                document.querySelector('#nova_poshta_branch_div label').textContent = 'Поштомат Нової Пошти *'
                NovaPoshtaBranchesInput.placeholder = 'Введіть назву поштомата'
                inputCategoryOfWarehouse.value = 'Postomat'
                NovaPoshtaContainer.style.display = 'grid'
                type === 'City' ? showCityElements() : showVillageElements()
            } else if (delivery === 'courier') {
                NovaPoshtaBranchDiv.style.display = 'none'
                AddressContainerStreet.style.display = 'block'
                AddressContainerBuild.style.display = 'block'
                AddressContainerKv.style.display = 'block'
                NovaPoshtaCityBranchContainer.appendChild(AddressContainerStreet)
                NovaPoshtaCityBranchContainer.appendChild(AddressContainerBuild)
                NovaPoshtaCityBranchContainer.appendChild(AddressContainerKv)
                inputCategoryOfWarehouse.value = ''
                if (type === 'City') {
                    NovaPoshtaCityDiv.style.display = 'grid'
                    DeliveryLocationVillageDistrict.style.display = 'none'
                    DeliveryLocationVillageRef.style.display = 'none'
                } else if (type === 'Village') {
                    NovaPoshtaCityDiv.style.display = 'none'
                    DeliveryLocationVillageDistrict.style.display = 'block'
                    DeliveryLocationVillageRef.style.display = 'block'
                }
            }
        
            if (NovaPoshtaRegionSelect && Region) {
                NovaPoshtaRegionSelect.addEventListener('change', function() {
                    Region.value = this.selectedOptions[0].text
                })
            }

            NovaPoshtaCityInput.addEventListener('input', function() {
                const regionRef = NovaPoshtaRegionSelect.value,
                    searchText = this.value.trim().toLowerCase()

                if (regionRef && searchText.length >= 0) {
                    NovaPoshtaFetchCities(regionRef, searchText)
                } else {
                    NovaPoshtaCityList.innerHTML = ''
                    NovaPoshtaCityList.classList.add('d-none')
                }
            })

            NovaPoshtaCityInput.addEventListener('focus', function() {
                const regionId = NovaPoshtaRegionSelect.value;

                if (regionId && NovaPoshtaCityInput.value.trim().length === 0) {
                    NovaPoshtaFetchCities(regionId, '');
                } else if (NovaPoshtaCityList.children.length > 0) {
                    NovaPoshtaCityList.classList.remove('d-none');
                }
            });

            NovaPoshtaBranchesInput.addEventListener('input', function() {
                let cityRef,
                    settlementType
                if (type === 'City') {
                    cityRef = CityRefHidden.value;
                    settlementType = 'місто';
                } else {
                    cityRef = VillageRef.value;
                    settlementType = 'село';
                }
                const searchText = this.value.trim().toLowerCase();
                if (cityRef  && searchText.length >= 0) {
                    NovaPoshtaFetchBranches(cityRef, searchText, settlementType);
                } else {
                    NovaPoshtaBranchesList.innerHTML = '';
                    NovaPoshtaBranchesList.classList.add('d-none');
                }
            });

            NovaPoshtaBranchesInput.addEventListener('focus', function() {
                let cityRef,
                    settlementType
                if (type === 'City') {
                    cityRef = CityRefHidden.value;
                    settlementType = 'місто';
                } else {
                    cityRef = VillageRef.value;
                    settlementType = 'село';
                }
                if (NovaPoshtaBranchesInput.value.trim().length === 0) {
                    NovaPoshtaFetchBranches(cityRef, '', settlementType);
                } else if (NovaPoshtaBranchesList.children.length > 0) {
                    NovaPoshtaBranchesList.classList.remove('d-none');
                }
            });

            DistrictInput.addEventListener('input', function() {
                const regionRef = NovaPoshtaRegionSelect.value,
                    searchText = this.value.trim().toLowerCase()

                if (regionRef && searchText.length >= 0) {
                    NovaPoshtaFetchDiscticts(regionRef, searchText);
                } else {
                    DistrictList.innerHTML = '';
                    DistrictList.classList.add('d-none');
                }
            });

            DistrictInput.addEventListener('focus', function() {
                const regionRef = NovaPoshtaRegionSelect.value;
                if (regionRef && DistrictInput.value.trim().length === 0) {
                    NovaPoshtaFetchDiscticts(regionRef, '');
                } else if (DistrictList.children.length > 0) {
                    DistrictList.classList.remove('d-none');
                }
            });

            document.addEventListener('click', function(event) {
                const isClickInsideCityList = NovaPoshtaCityList.contains(event.target) || event.target === NovaPoshtaCityInput;
                const isClickInsideBranchesList = NovaPoshtaBranchesList.contains(event.target) || event.target === NovaPoshtaBranchesInput;

                if (!isClickInsideCityList) {
                    NovaPoshtaCityList.classList.add('d-none');
                }

                if (!isClickInsideCityList) {
                    NovaPoshtaCityList.classList.add('d-none');
                }

                if (!isClickInsideBranchesList) {
                    NovaPoshtaBranchesList.classList.add('d-none');
                }
            });

            function NovaPoshtaFetchCities(regionRef, searchText) {
                // console.log(regionRef);
                fetch('/get-nova-poshta-cities', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ region_ref: regionRef, findByString: searchText })
                })
                .then(response => response.json() )
                    .then(data => {
                        NovaPoshtaCityList.innerHTML = '';
                        data.forEach(city => {
                            console.log(city)
                            if (type === 'City') {
                                if (city.description.toLowerCase().includes(searchText) && city.settlement_type_description.toLowerCase().includes('місто')) {
                                    const listItem = document.createElement('li');
                                    listItem.textContent = city.settlement_type_description + ' ' + city.description;
                                    listItem.setAttribute('data-value', city.ref);
                                    listItem.classList.add('py-2', 'px-3', 'hover:bg-gray-100', 'cursor-pointer');
                                    listItem.addEventListener('click', function() {
                                        NovaPoshtaCityInput.value = city.description;
                                        CityName.value = city.description
                                        CityRefHidden.value = city.ref;
                                        NovaPoshtaCityList.classList.add('d-none');
                                        MeestBranchesInput.value = '';
                                        NovaPoshtaBranchesList.innerHTML = '';
                                    });
                                    NovaPoshtaCityList.appendChild(listItem);
                                }
                            }
                        });
                        if (NovaPoshtaCityList.children.length > 0) {
                            NovaPoshtaCityList.classList.remove('d-none');
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }

            function NovaPoshtaFetchBranches(cityRef, searchText, settlementType) {
                const categoryOfWarehouse = document.getElementById('categoryOfWarehouse').value;
                fetch('/get-nova-poshta-branches', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ city_ref: cityRef, search: searchText, settlementType: settlementType })
                })
                    .then(response => response.json())
                    .then(data => {
                        NovaPoshtaBranchesList.innerHTML = '';
                        data.forEach(branch => {
                            if (categoryOfWarehouse === 'Postomat' && branch.type_of_warehouse.toLowerCase().includes('f9316480-5f2d-425d-bc2c-ac7cd29decf0')) {
                                if (branch.description.toLowerCase().includes(searchText)) {
                                    const listItem = document.createElement('li');
                                    listItem.textContent = branch.description;
                                    listItem.setAttribute('data-value', branch.ref);
                                    listItem.classList.add('py-2', 'px-3', 'hover:bg-gray-100', 'cursor-pointer');
                                    listItem.addEventListener('click', function() {
                                        NovaPoshtaBranchesInput.value = this.textContent;
                                        BranchRefHidden.value = branch.ref;
                                        BranchNumber.value = branch.number;
                                        NovaPoshtaBranchesList.classList.add('d-none');
                                    });
                                    NovaPoshtaBranchesList.appendChild(listItem);
                                }
                            } else if(categoryOfWarehouse === 'Branch' && !branch.type_of_warehouse.toLowerCase().includes('f9316480-5f2d-425d-bc2c-ac7cd29decf0')) {
                                if (branch.description.toLowerCase().includes(searchText)) {
                                    const listItem = document.createElement('li');
                                    listItem.textContent = branch.description;
                                    listItem.setAttribute('data-value', branch.ref);
                                    listItem.classList.add('py-2', 'px-3', 'hover:bg-gray-100', 'cursor-pointer');
                                    listItem.addEventListener('click', function () {
                                        NovaPoshtaBranchesInput.value = this.textContent;
                                        BranchRefHidden.value = branch.ref;
                                        BranchNumber.value = branch.number;
                                        NovaPoshtaBranchesList.classList.add('d-none');
                                    });
                                    NovaPoshtaBranchesList.appendChild(listItem);
                                }
                            }
                        });
                        if (NovaPoshtaBranchesList.children.length > 0) {
                            NovaPoshtaBranchesList.classList.remove('d-none');
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }

            function NovaPoshtaFetchStreets(CityName, searchText) {
                fetch('/get-nova-poshta-streets', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ city_name: CityName, search: searchText })
                })
                    .then(response => response.json())
                    .then(data => {
                        StreetList.innerHTML = '';
                        data.forEach(street => {
                            if (street.Description.toLowerCase().includes(searchText) || street.StreetsType.toLowerCase().includes(searchText) || (street.StreetsType+' '+street.Description).toLowerCase().includes(searchText)) {
                                const listItem = document.createElement('li');
                                listItem.textContent = street.StreetsType + ' ' + street.Description;
                                listItem.setAttribute('data-value', street.Ref);
                                listItem.classList.add('py-2', 'px-3', 'hover:bg-gray-100', 'cursor-pointer');
                                listItem.addEventListener('click', function() {
                                    StreetInput.value = this.textContent;
                                    StreetRef.value = street.Ref;
                                    StreetList.classList.add('d-none');
                                });
                                StreetList.appendChild(listItem);
                            }
                        });
                        if (StreetList.children.length > 0) {
                            StreetList.classList.remove('d-none');
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }

            function NovaPoshtaFetchDiscticts(regionRef, searchText) {
                fetch('/get-nova-poshta-settlement-districts', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ region_ref: regionRef, search: searchText })
                })
                    .then(response => response.json())
                    .then(data => {
                        DistrictList.innerHTML = '';
                        data.forEach(district => {
                            if (district.description.toLowerCase().includes(searchText)) {
                                const listItem = document.createElement('li');
                                listItem.textContent = district.description + ' район';
                                listItem.setAttribute('data-value', district.ref);
                                listItem.classList.add('py-2', 'px-3', 'hover:bg-gray-100', 'cursor-pointer');
                                listItem.addEventListener('click', function() {
                                    DistrictInput.value = this.textContent;
                                    DistrictRef.value = district.ref;
                                    DistrictList.classList.add('d-none');
                                });
                                DistrictList.appendChild(listItem);
                            }
                        });
                        if (DistrictList.children.length > 0) {
                            DistrictList.classList.remove('d-none');
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }

            function NovaPoshtaFetchVillages(districtRef, searchText) {
                fetch('/get-nova-poshta-settlement-villages', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ district_ref: districtRef, search: searchText })
                })
                    .then(response => response.json())
                    .then(data => {
                        VillageList.innerHTML = '';
                        data.forEach(village => {
                            if ((village.description.toLowerCase().includes(searchText) || village.settlement_type_description.toLowerCase().includes(searchText) || (village.settlement_type_description+' '+village.description).toLowerCase().includes(searchText)) && !village.settlement_type_description.toLowerCase().includes('місто')) {
                                const listItem = document.createElement('li');
                                listItem.textContent = village.settlement_type_description + ' ' + village.description;
                                listItem.setAttribute('data-value', village.ref);
                                listItem.classList.add('py-2', 'px-3', 'hover:bg-gray-100', 'cursor-pointer');
                                listItem.addEventListener('click', function() {
                                    CityName.value = village.description
                                    VillageInput.value = this.textContent;
                                    VillageRef.value = village.ref;
                                    VillageList.classList.add('d-none');
                                });
                                VillageList.appendChild(listItem);
                            }
                        });
                        if (VillageList.children.length > 0) {
                            VillageList.classList.remove('d-none');
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }
        } else if (poshta === 'Meest') {
            MeestCityBranchDiv.style.display = 'block';
            MeestCityhDiv.style.display = 'block';
            // DeliveryLocationTypeContainer.style.display = "none"
            NovaPoshtaContainer.classList.add('d-none');
            MeestContainer.classList.remove('d-none');
            UkrPoshtaCityDiv.classList.add('d-none')
            UkrPoshtaRegionSelect.classList.add('d-none')
            DeliveryLocationVillageDistrict.style.display = "none"
            DeliveryLocationVillageRef.style.display = "none"
            UkrPoshtaBranchDiv.classList.add('d-none')
            
            if (delivery === 'branch') {
                // DeliveryLocationTypeContainer.style.display = "none"
                MeestBranchesContainer.style.display = 'grid';
                AddressContainerStreet.style.display = 'none'
                AddressContainerBuild.style.display = 'none'
                AddressContainerKv.style.display = 'none'
                document.querySelector('#meest_branch_div label').textContent = 'Відділення Meest';
                MeestBranchesInput.placeholder = 'Введіть назву відділення';
                inputCategoryOfWarehouse.value = '';
            } else if (delivery === 'courier') {
                // DeliveryLocationTypeContainer.style.display = "none"
                MeestBranchesContainer.style.display = 'none';
                AddressContainerStreet.style.display = 'block'
                AddressContainerBuild.style.display = 'block'
                AddressContainerKv.style.display = 'block'
                inputCategoryOfWarehouse.value = '';
                MeestContainer.appendChild(AddressContainerStreet)
                MeestContainer.appendChild(AddressContainerBuild)
                MeestContainer.appendChild(AddressContainerKv)
            }

            MeestCityInput.addEventListener('input', function() {
                const regionId = MeestRegionSelect.value;
                const searchText = this.value.trim().toLowerCase();

                if (regionId && searchText.length >= 1) {
                    MeestFetchCities(regionId, searchText);
                } else {
                    MeestCityList.innerHTML = '';
                    MeestCityList.classList.add('d-none');
                }
            });

            MeestCityInput.addEventListener('focus', function() {
                const regionId = MeestRegionSelect.value;
                if (regionId && MeestCityInput.value.trim().length === 0) {
                    MeestFetchCities(regionId, '');
                } else if (MeestCityList.children.length > 0) {
                    MeestCityList.classList.remove('d-none');
                }
            });

            MeestBranchesInput.addEventListener('input', function() {
                const cityId = document.querySelector('#meest_city_list li[data-value]')?.getAttribute('data-value');
                const searchText = this.value.trim().toLowerCase();
                if (cityId && searchText.length > 1) {
                    MeestFetchBranches(cityId, searchText);
                } else {
                    MeestBranchesList.innerHTML = '';
                    MeestBranchesList.classList.add('d-none');
                }
            });

            MeestBranchesInput.addEventListener('focus', function() {
                const cityId = document.querySelector('#meest_city_list li[data-value]')?.getAttribute('data-value');
                if (cityId && MeestBranchesInput.value.trim().length === 0) {
                    MeestFetchBranches(cityId, '');
                } else if (MeestBranchesList.children.length > 0) {
                    MeestBranchesList.classList.remove('d-none');
                }
            });

            document.addEventListener('click', function(event) {
                const isClickInsideCityList = MeestCityList.contains(event.target) || event.target === MeestCityInput;
                const isClickInsideBranchesList = MeestBranchesList.contains(event.target) || event.target === MeestBranchesInput;

                if (!isClickInsideCityList) {
                    MeestCityList.classList.add('d-none');
                }

                if (!isClickInsideBranchesList) {
                    MeestBranchesList.classList.add('d-none');
                }
            });

            if (MeestRegionSelect && Region) {
                MeestRegionSelect.addEventListener('change', function() {
                    Region.value = this.selectedOptions[0].text;
                });
            }

            function MeestFetchCities(regionId, searchText) {
                fetch('/meest/cities', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ regionId: regionId })
                })
                    .then(response => response.json())
                    .then(data => {
                        MeestCityList.innerHTML = '';
                        data.forEach(city => {
                            if (city.description.toLowerCase().includes(searchText)) {
                                const listItem = document.createElement('li');
                                listItem.textContent = city.description + ' ' + city.city_type.toLowerCase();
                                listItem.setAttribute('data-value', city.city_id);
                                listItem.classList.add('py-2', 'px-3', 'hover:bg-gray-100', 'cursor-pointer');
                                listItem.addEventListener('click', function() {
                                    MeestCityInput.value = city.description;
                                    CityRefHidden.value = city.city_id;
                                    MeestCityList.classList.add('d-none');
                                    MeestBranchesInput.value = '';
                                    MeestBranchesList.innerHTML = '';
                                });
                                MeestCityList.appendChild(listItem);
                            }
                        });
                        if (MeestCityList.children.length > 0) {
                            MeestCityList.classList.remove('d-none');
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }

            function MeestFetchBranches(cityId, searchText) {
                fetch('/meest/branches', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ cityId: cityId })
                })
                    .then(response => response.json())
                    .then(data => {
                        MeestBranchesList.innerHTML = '';
                        data.forEach(branch => {
                            const listItem = document.createElement('li');
                            if (branch.branch_type.toLowerCase().includes(searchText) || branch.address.toLowerCase().includes(searchText)) {
                                listItem.textContent = branch.branch_type + ' ' + branch.address;
                                listItem.setAttribute('data-value', branch.branch_id);
                                listItem.classList.add('py-2', 'px-3', 'hover:bg-gray-100', 'cursor-pointer');
                                listItem.addEventListener('click', function () {
                                    MeestBranchesInput.value = branch.branch_type + ' ' + branch.address;
                                    BranchRefHidden.value = branch.branch_id;
                                    MeestBranchesList.classList.add('d-none');
                                });
                                MeestBranchesList.appendChild(listItem);
                            }
                        });
                        if (MeestBranchesList.children.length > 0) {
                            MeestBranchesList.classList.remove('d-none');
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }
        } else if (poshta === 'UkrPoshta') {
            const showCityElements = () => {
                DeliveryLocationVillageDistrict.style.display = 'none';
                DeliveryLocationVillageRef.style.display = 'none';
                UkrPoshtaCityDiv.classList.remove('d-none');
            };
        
            const showVillageElements = () => {
                DeliveryLocationVillageDistrict.style.display = 'block';
                DeliveryLocationVillageRef.style.display = 'block';
                UkrPoshtaCityDiv.classList.add('d-none');
                const parentElement = UkrPoshtaBranchDiv.parentNode;
                parentElement.insertBefore(DeliveryLocationVillageDistrict, UkrPoshtaBranchDiv);
                parentElement.insertBefore(DeliveryLocationVillageRef, UkrPoshtaBranchDiv);
                
            };
        
            UkrPoshtaCityDiv.style.display = 'grid';
            UkrPoshtaBranchDiv.style.display = 'grid';
            NovaPoshtaContainer.style.display = 'none';
            MeestContainer.classList.add('d-none');
            UkrPoshtaBranchDiv.classList.remove('d-none')
            UkrPoshtaCityDiv.classList.remove('d-none')
            UkrPoshtaRegionSelect.classList.remove('d-none')
            DeliveryLocationVillageDistrict.style.display = 'none';
            DeliveryLocationVillageRef.style.display = 'none';
            AddressContainerStreet.style.display = 'none'
            AddressContainerBuild.style.display = 'none'
            AddressContainerKv.style.display = 'none'
        
            if (delivery === 'exspresBranch' || delivery === 'branch') {
                type === 'City' ? showCityElements() : showVillageElements();
                UkrPoshtaBranchDiv.style.display = 'grid';
                AddressContainerStreet.style.display = 'none'
                AddressContainerBuild.style.display = 'none'
                AddressContainerKv.style.display = 'none'
                document.querySelector('#ukr_poshta_branch_div label').textContent = 'Відділення УкрПошта';
                UkrPoshtaCityInput.placeholder = 'Введіть назву відділення';
            } else if (delivery === 'exspresCourier' || delivery === 'courier') {
                UkrPoshtaBranchDiv.style.display = 'none';
                AddressContainerStreet.style.display = 'block'
                AddressContainerBuild.style.display = 'block'
                AddressContainerKv.style.display = 'block'
                type === 'City' ? showCityElements() : showVillageElements();
            }

            UkrPoshtaCityInput.addEventListener('input', function() {
                const regionId = UkrPoshtaRegionSelect.value;
                const searchText = this.value.trim().toLowerCase();
                if (regionId && searchText.length > 0) {
                    fetchCities('', regionId, searchText);
                } else {
                    UkrPoshtaCityList.innerHTML = '';
                    UkrPoshtaCityList.classList.add('d-none');
                }
            });

            UkrPoshtaCityInput.addEventListener('focus', function() {
                const regionId = UkrPoshtaRegionSelect.value;
                if (regionId && UkrPoshtaCityInput.value.trim().length === 0) {
                    fetchCities('', regionId, '');
                } else if (UkrPoshtaCityInput.children.length >= 0) {
                    UkrPoshtaCityList.classList.remove('d-none');
                }
            });

            UkrPoshtaBranchesInput.addEventListener('input', function() {
                const searchText = this.value.trim().toLowerCase();
                let cityId;
                if (type === 'City') {
                    cityId = CityRefHidden.value;
                } else if (type === 'Village') {
                    cityId = VillageRef.value;
                }
                if (cityId && searchText.length > 0) {
                    fetchBranches(cityId, searchText);
                } else {
                    UkrPoshtaBranchesList.innerHTML = '';
                    UkrPoshtaBranchesList.classList.add('d-none');
                }
            });

            UkrPoshtaBranchesInput.addEventListener('focus', function() {
                let cityId;
                if (type === 'City') {
                    cityId = CityRefHidden.value;
                } else if (type === 'Village') {
                    cityId = VillageRef.value;
                }
                if (UkrPoshtaBranchesInput.value.trim().length === 0) {
                    fetchBranches(cityId, '');
                } else if (UkrPoshtaBranchesList.children.length >= 0) {
                    UkrPoshtaBranchesList.classList.remove('d-none');
                }
            });

            DistrictInput.addEventListener('input', function() {
                const regionRef = UkrPoshtaRegionSelect.value;
                const searchText = this.value.trim().toLowerCase();

                if (regionRef && searchText.length >= 0) {
                    fetchDistricts(regionRef, searchText);
                } else {
                    DistrictList.innerHTML = '';
                    DistrictList.classList.add('d-none');
                }
            });

            DistrictInput.addEventListener('focus', function() {
                const regionRef = UkrPoshtaRegionSelect.value;
                if (regionRef && DistrictInput.value.trim().length === 0) {
                    fetchDistricts(regionRef, '');
                } else if (DistrictList.children.length > 0) {
                    DistrictList.classList.remove('d-none');
                }
            });

            document.addEventListener('click', function(event) {
                const isClickInsideCityList = UkrPoshtaCityList.contains(event.target) || event.target === UkrPoshtaCityInput;
                const isClickInsideBranchesList = UkrPoshtaBranchesList.contains(event.target) || event.target === UkrPoshtaBranchesInput;

                if (!isClickInsideCityList) {
                    UkrPoshtaCityList.classList.add('d-none');
                }

                if (!isClickInsideBranchesList) {
                    UkrPoshtaBranchesList.classList.add('d-none');
                }
            });

            if (UkrPoshtaRegionSelect && Region) {
                UkrPoshtaRegionSelect.addEventListener('change', function() {
                    Region.value = this.selectedOptions[0].text;
                });
            }

            function fetchCities(districtId, regionId, searchText) {
                fetch(`/get-ukr-poshta-cities?region_id=${regionId}&district_id=${districtId}`, {
                    method: 'GET',
                    headers: {
                        'accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        UkrPoshtaCityList.innerHTML = '';
                        VillageList.innerHTML = '';
                        data.forEach(city => {
                            if (type === 'City') {
                                if (city.description.toLowerCase().startsWith(searchText) && city.settlement_type.toLowerCase().includes('місто')) {
                                    const listItem = document.createElement('li');
                                    listItem.textContent = city.settlement_type + ' ' + city.description;
                                    listItem.setAttribute('data-value', city.settlement_id);
                                    listItem.classList.add('py-2', 'px-3', 'hover:bg-gray-100', 'cursor-pointer');
                                    listItem.addEventListener('click', function() {
                                        UkrPoshtaCityInput.value = city.description;
                                        CityName.value = city.description;
                                        CityRefHidden.value = city.settlement_id;
                                        UkrPoshtaCityList.classList.add('d-none');
                                        UkrPoshtaBranchesInput.value = '';
                                        UkrPoshtaBranchesList.innerHTML = '';
                                    });
                                    UkrPoshtaCityList.appendChild(listItem);
                                }
                            } else {
                                if (city.description.toLowerCase().startsWith(searchText) && !city.settlement_type.toLowerCase().includes('місто')) {
                                    const listItem = document.createElement('li');
                                    listItem.textContent = city.settlement_type + ' ' + city.description;
                                    listItem.setAttribute('data-value', city.settlement_id);
                                    listItem.classList.add('py-2', 'px-3', 'hover:bg-gray-100', 'cursor-pointer');
                                    listItem.addEventListener('click', function() {
                                        VillageInput.value = city.description;
                                        VillageRef.value = city.settlement_id;
                                        VillageList.classList.add('d-none');
                                        UkrPoshtaBranchesInput.value = '';
                                        UkrPoshtaBranchesList.innerHTML = '';
                                    });
                                    VillageList.appendChild(listItem);
                                }
                            }
                        });
                        if (UkrPoshtaCityList.children.length > 0) {
                            UkrPoshtaCityList.classList.remove('d-none');
                        } else {
                            VillageList.classList.remove('d-none');
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }

            function fetchBranches(cityId, searchText) {
                fetch(`/get-ukr-poshta-branches?cityId=${cityId}`, {
                    method: 'GET',
                    headers: {
                        'accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        UkrPoshtaBranchesList.innerHTML = '';
                        data.forEach(branch => {
                            const listItem = document.createElement('li');
                            if (branch.POSTOFFICE_UA.toLowerCase().includes(searchText.toLowerCase()) || branch.STREET_UA_VPZ.toLowerCase().includes(searchText.toLowerCase())) {
                                listItem.textContent = branch.POSTOFFICE_UA + (branch.STREET_UA_VPZ ? ' ' + branch.STREET_UA_VPZ : '');
                                listItem.setAttribute('data-value', branch.POSTOFFICE_UA);
                                listItem.classList.add('py-2', 'px-3', 'hover:bg-gray-100', 'cursor-pointer');
                                listItem.addEventListener('click', function() {
                                    UkrPoshtaBranchesInput.value = branch.POSTOFFICE_UA + (branch.STREET_UA_VPZ ? ' ' + branch.STREET_UA_VPZ : '');
                                    BranchRefHidden.value = branch.POSTOFFICE_ID;
                                    UkrPoshtaBranchesList.classList.add('d-none');
                                });
                                UkrPoshtaBranchesList.appendChild(listItem);
                            }
                        });
                        if (UkrPoshtaBranchesList.children.length > 0) {
                            UkrPoshtaBranchesList.classList.remove('d-none');
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }

            function fetchDistricts(regionId, searchText) {
                fetch(`/get-ukr-poshta-districts?regionId=${regionId}`, {
                    method: 'GET',
                    headers: {
                        'accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        DistrictList.innerHTML = '';
                        data.forEach(district => {
                            const listItem = document.createElement('li');
                            if (district.description.toLowerCase().includes(searchText.toLowerCase())) {
                                listItem.textContent = district.description;
                                listItem.setAttribute('data-value', district.district_id);
                                listItem.classList.add('py-2', 'px-3', 'hover:bg-gray-100', 'cursor-pointer');
                                listItem.addEventListener('click', function() {
                                    DistrictInput.value = this.textContent;
                                    DistrictRef.value = district.district_id;
                                    DistrictList.classList.add('d-none');
                                    VillageInput.value = '';
                                    VillageList.innerHTML = '';
                                });
                                DistrictList.appendChild(listItem);
                            }
                        });
                        if (DistrictList.children.length > 0) {
                            DistrictList.classList.remove('d-none');
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }

            function fetchStreets(cityId, searchText) {
                fetch(`/get-ukr-poshta-streets?cityId=${cityId}`, {
                    method: 'GET',
                    headers: {
                        'accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        StreetList.innerHTML = '';
                        data.forEach(street => {
                            const listItem = document.createElement('li');
                            if (street.STREET_UA.toLowerCase().includes(searchText.toLowerCase())) {
                                listItem.textContent = street.SHORTSTREETTYPE_UA + ' ' + street.STREET_UA;
                                listItem.setAttribute('data-value', street.DISTRICT_ID);
                                listItem.classList.add('py-2', 'px-3', 'hover:bg-gray-100', 'cursor-pointer');
                                listItem.addEventListener('click', function() {
                                    StreetInput.value = this.textContent;
                                    StreetRef.value = street.STREET_ID;
                                    StreetList.classList.add('d-none');
                                    House.value = '';
                                    Flat.value = '';
                                });
                                StreetList.appendChild(listItem);
                            }
                        });
                        if (StreetList.children.length > 0) {
                            StreetList.classList.remove('d-none');
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }
        }
    }
