const app = {};
app.ajaxPetition = function (url, method, data, callback, formdata = 0) {
    var petition = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject(Microsft.XMLHTTP);
    petition.onreadystatechange = function () {
        if (petition.readyState == 4 && petition.status == 200) {
            callback(JSON.parse(petition.responseText));
            return true;
        }
    }
    if (method == 'get') {
        petition.open(method, url + data, true);
        petition.send();
    } else {
        petition.open(method, url, true);
        if (formdata == 0) petition.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        petition.send(data);
    }
}
app.probeInputs = function (form) {
    inputs = form.getElementsByClassName('form-input');
    var invalidInputs = {};
    invalidInputs.num = 0;
    var minLength = 1;
    for (i = 0; i < inputs.length; i++) {
        if (inputs[i].type == 'file' && inputs[i].required == 1 || inputs[i].type !== 'file') {
            if (inputs[i].value.length < minLength || inputs[i].value == null) {
                invalidInputs.num = invalidInputs.num + 1;
            }
        }
        if (inputs[i].type == 'file') {
            invalidInputs.num = 0;
        }
    }
    if (invalidInputs.num == 0) {
        form.submit.style.background = '';
        form.submit.disabled = false;
    } else {
        form.submit.style.background = 'rgb(255, 216, 0,.6)';
        form.submit.disabled = true;
    }
    invalidInputs.num = 0;
}

document.addEventListener("DOMContentLoaded", () => {
    // Declaracion del objeto de carga de publicaciones
    const postLoaders = {};
    postLoaders.accountContainer = document.getElementById('account-posts-container');
    postLoaders.homeContainer = document.getElementById('home-posts-container');
    postLoaders.more = document.getElementById('posts-container-load-more');
    postLoaders.bloqued = false;

    postLoaders.load = function (page) {
        if (postLoaders.accountContainer) {
            postLoaders.accountUsername = postLoaders.accountContainer.attributes.accountusername.value;
            postLoaders.account(postLoaders.accountUsername, page);
        }
        if (postLoaders.homeContainer) {
            postLoaders.home(page);
        }
    }

    postLoaders.renderData = function (data, container) {
        if (data.state == 1 || data.state == 3) {
            if (data.actual_page == 1) {
                container.innerHTML = '';
            }
            container.innerHTML += data.html;
            postLoaders.removeClassForAnimation();
            postLoaders.more.attributes.page.value = data.next_page;
        }
        if (data.state == 3) {
            postLoaders.bloqued = true;
        } else {
            setTimeout(() => {
                postLoaders.bloqued = false;
            }, 1000);
        }
    }

    postLoaders.account = function (username, page) {
        app.ajaxPetition('ajax/load_posts.php', 'get', '?username=' + username + '&page=' + page, function (data) {
            postLoaders.renderData(data, postLoaders.accountContainer);
        });
    }
    postLoaders.home = function (page) {
        app.ajaxPetition('ajax/load_posts.php', 'get', '?page=' + page, function (data) {
            postLoaders.renderData(data, postLoaders.homeContainer);
        });
    }
    postLoaders.removeClassForAnimation = async function () {
        var newPosts = document.querySelectorAll('.posts-container .post-container.new');
        const removeClass = (post => {
            return new Promise((resolve, reject) => {
                setTimeout(() => {
                    post.classList.remove('new');
                    return resolve();
                }, 100);
            })
        });
        for (let post of newPosts) {
            await removeClass(post);
        };
    }

    postLoaders.load(1);

    // Declaracion del objeto de interaccion con publicaciones
    const postInteraction = {};
    postInteraction.like = function (element) {
        app.ajaxPetition('php/posts_like.php', 'get', '?token=' + element.parentElement.parentElement.parentElement.id, function (data) {
            if (data.state == 1) {
                data.user_liked == 0 ? element.classList.remove('selected') : element.classList.add('selected');
                element.parentElement.getElementsByClassName('num')[0].innerHTML = data.likes_let;
            }
        });
    }

    const userInteractions = {};
    userInteractions.follow = function (element) {
        app.ajaxPetition('php/users_follows.php', 'get', '?token=' + element.parentElement.id, function (data) {
            if (data.state == 1) {
                if (data.user_followed == 0) {
                    element.parentElement.classList.remove('active');
                    element.parentElement.classList.add('inactive');
                } else {
                    element.parentElement.classList.remove('inactive');
                    element.parentElement.classList.add('active');
                }
            }
        });
    }

    const userFollows = {};
    userFollows.followersContainer = document.getElementById('account-followers-container');
    userFollows.followersLoadMore = document.getElementById('followers-container-load-more');
    userFollows.followingContainer = document.getElementById('account-following-container');
    userFollows.followingLoadMore = document.getElementById('following-container-load-more');

    userFollows.get = function (container, tab, page) {
        app.ajaxPetition('php/users_follows_list.php', 'get', '?username=' + container.attributes.accountUsername.value + '&tab=' + tab + '&page=' + page, function (data) {
            if (data.state == 1) {
                container.innerHTML += data.users;
            }
            if (data.state == 3) {
                container.innerHTML += data.users;
            }
            if (data.state == 0) {
            }
        });
    }

    if (userFollows.followersContainer) {
        userFollows.get(userFollows.followersContainer, 'followers', userFollows.followersLoadMore.attributes.page.value);
    }
    if (userFollows.followingContainer) {
        userFollows.get(userFollows.followingContainer, 'following', userFollows.followingLoadMore.attributes.page.value);
    }

    // Funciones de click
    document.addEventListener('click', (e) => {
        if (e.target.classList.contains('post-interactions-like')) {
            postInteraction.like(e.target);
        }
        if (e.target.classList.contains('user-interactions-follow-btn')) {
            userInteractions.follow(e.target);
        }
        if (e.target.parentElement.classList.contains('user-interactions-follow-btn')) {
            userInteractions.follow(e.target.parentElement);
        }

        if (e.target.classList.contains('post-compose-img-remove')) {
            postCompose.removeImgVisor(e.target.parentElement);
        }
    });

    window.addEventListener("scroll", async function (event) {
        var scrollHeight = this.scrollY;
        var viewportHeight = document.documentElement.clientHeight;
        var moreScroll = (postLoaders.more.offsetTop) - 100;
        var currentScroll = scrollHeight + viewportHeight;
        if ((currentScroll >= moreScroll) && postLoaders.bloqued == false) {
            postLoaders.bloqued = true;
            var page = postLoaders.more.attributes.page.value;
            postLoaders.load(page);
        }
    });
});

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('change', () => {
            app.probeInputs(form);
        });
        form.addEventListener('keyup', () => {
            app.probeInputs(form);
        });
        app.probeInputs(form);
    });
});