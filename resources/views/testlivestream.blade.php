@extends('layout_agora.app')

@section('content')
    <div class="container-fluid banner">
        <p class="banner-text">Audio Mixing & Audio Effect</p>
        <a style="color: rgb(255, 255, 255);fill: rgb(255, 255, 255);fill-rule: evenodd; position: absolute; right: 10px; top: 4px;"
            class="Header-link " href="https://github.com/AgoraIO/API-Examples-Web/tree/main/Demo">
            <svg class="octicon octicon-mark-github v-align-middle" height="32" viewBox="0 0 16 16" version="1.1"
                width="32" aria-hidden="true">
                <path fill-rule="evenodd"
                    d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.013 8.013 0 0016 8c0-4.42-3.58-8-8-8z">
                </path>
            </svg>
        </a>
    </div>
    <div class="container">
        <form id="join-form">
            <div class="row join-info-group">
            </div>

            <div class="button-group">
                <button id="join" type="submit" class="btn btn-primary btn-sm">Join</button>
                <button id="leave" type="button" class="btn btn-primary btn-sm" disabled>Leave</button>
            </div>
        </form>

        <div class="button-group">
            <div style="margin-bottom: 10px;">
                <button id="local-audio-mixing" type="button" class="btn btn-primary btn-sm" disabled>Start Local Audio
                    Mixing</button>
            </div>

        </div>

        <div class="audio-controls">
            <div class="play-button"><a href="#" title="play audio mixing" class="play"></a></div>
            <div class="audio-bar">
                <div class="progress">
                    <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                    </div>
                </div>
            </div>
            <div class="audio-time"><span class="audio-current-time">00:00</span>/<span class="audio-duration">00:00</span>
            </div>
        </div>

        <div class="audio-volume-controls">
            <div class="audio-volume-bar">
                <label for="volume">Audio Mixing Volume</label>
                <input id="volume" type="range" class="custom-range" value="100" min="0" max="100" />
            </div>
        </div>

        <div class="row video-group">
            <div class="col">
                <p id="local-player-name" class="player-name"></p>
                <div id="local-player" class="player"></div>
            </div>
            <div class="w-100"></div>
            <div class="col">
                <div id="remote-playerlist"></div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        // create Agora client
        var client = AgoraRTC.createClient({
            mode: "rtc",
            codec: "vp8"
        });
        var localTracks = {
            videoTrack: null,
            audioTrack: null,
            audioMixingTrack: null,
            audioEffectTrack: null
        };
        var remoteUsers = {};
        // Agora client options
        var options = {
            appid: null,
            channel: null
        };
        var audioMixing = {
            state: "IDLE",
            // "IDLE" | "LOADING | "PLAYING" | "PAUSE"
            duration: 0
        };
        const playButton = $(".play");
        let audioMixingProgressAnimation;
        $("#join-form").submit(async function(e) {
            e.preventDefault();
            $("#join").attr("disabled", true);
            try {
                options.channel = "{{ env('AGORA_CHANNEL') }}";
                options.appid = "{{ env('AGORA_APP_ID') }}";
                await join();
                $("#success-alert a").attr("href",
                    `index.html?appid=${options.appid}&channel=${options.channel}`
                );
                $("#success-alert").css("display", "block");
            } catch (error) {
                console.error(error);
            } finally {
                $("#leave").attr("disabled", false);
                $("#audio-mixing").attr("disabled", false);
                $("#local-audio-mixing").attr("disabled", false);
            }
        });
        $("#leave").click(async function(e) {
            leave();
        });
        $("#audio-mixing").click(function(e) {
            startAudioMixing();
        });
        $(".audio-bar .progress").click(function(e) {
            setAudioMixingPosition(e.offsetX);
            return false;
        });
        $("#volume").click(function(e) {
            setVolume($("#volume").val());
        });
        $("#local-audio-mixing").click(function(e) {
            // get selected file
          //  const file = $("#local-file").prop("files")[0];
            const file = "{{ $sound }}";
            if (!file) {
                console.warn("please choose a audio file");
                return;
            }
            startAudioMixing(file);
            return false;
        });
        playButton.click(function() {
            if (audioMixing.state === "IDLE" || audioMixing.state === "LOADING") return;
            toggleAudioMixing();
            return false;
        });

        function setAudioMixingPosition(clickPosX) {
            if (audioMixing.state === "IDLE" || audioMixing.state === "LOADING") return;
            const newPosition = clickPosX / $(".progress").width();

            // set the audio mixing playing position
            localTracks.audioMixingTrack.seekAudioBuffer(newPosition * audioMixing.duration);
        }

        function setVolume(value) {
            // set the audio mixing playing position
            localTracks.audioMixingTrack.setVolume(parseInt(value));
        }
        async function startAudioMixing(file) {
            if (audioMixing.state === "PLAYING" || audioMixing.state === "LOADING") return;
            const options = {};
            if (file) {
                options.source = file;
            } else {
                options.source = "HeroicAdventure.mp3";
            }
            try {
                audioMixing.state = "LOADING";
                // if the published track will not be used, you had better unpublish it
                if (localTracks.audioMixingTrack) {
                    await client.unpublish(localTracks.audioMixingTrack);
                }
                // start audio mixing with local file or the preset file
                localTracks.audioMixingTrack = await AgoraRTC.createBufferSourceAudioTrack(options);
                await client.publish(localTracks.audioMixingTrack);
                localTracks.audioMixingTrack.play();
                localTracks.audioMixingTrack.startProcessAudioBuffer({
                    loop: true
                });
                audioMixing.duration = localTracks.audioMixingTrack.duration;
                $(".audio-duration").text(toMMSS(audioMixing.duration));
                playButton.toggleClass('active', true);
                setAudioMixingProgress();
                audioMixing.state = "PLAYING";
                console.log("start audio mixing");
            } catch (e) {
                audioMixing.state = "IDLE";
                console.error(e);
            }
        }

        function stopAudioMixing() {
            if (audioMixing.state === "IDLE" || audioMixing.state === "LOADING") return;
            audioMixing.state = "IDLE";

            // stop audio mixing track
            localTracks.audioMixingTrack.stopProcessAudioBuffer();
            localTracks.audioMixingTrack.stop();
            $(".progress-bar").css("width", "0%");
            $(".audio-current-time").text(toMMSS(0));
            $(".audio-duration").text(toMMSS(0));
            playButton.toggleClass('active', false);
            cancelAnimationFrame(audioMixingProgressAnimation);
            console.log("stop audio mixing");
        }

        function toggleAudioMixing() {
            if (audioMixing.state === "PAUSE") {
                playButton.toggleClass('active', true);

                // resume audio mixing
                localTracks.audioMixingTrack.resumeProcessAudioBuffer();
                audioMixing.state = "PLAYING";
            } else {
                playButton.toggleClass('active', false);

                // pause audio mixing
                localTracks.audioMixingTrack.pauseProcessAudioBuffer();
                audioMixing.state = "PAUSE";
            }
        }

        function setAudioMixingProgress() {
            audioMixingProgressAnimation = requestAnimationFrame(setAudioMixingProgress);
            const currentTime = localTracks.audioMixingTrack.getCurrentTime();
            $(".progress-bar").css("width", `${currentTime / audioMixing.duration * 100}%`);
            $(".audio-current-time").text(toMMSS(currentTime));
        }

        // use buffer source audio track to play effect.
        async function playEffect(cycle, options) {
            // if the published track will not be used, you had better unpublish it
            if (localTracks.audioEffectTrack) {
                await client.unpublish(localTracks.audioEffectTrack);
            }
            localTracks.audioEffectTrack = await AgoraRTC.createBufferSourceAudioTrack(options);
            await client.publish(localTracks.audioEffectTrack);
            localTracks.audioEffectTrack.play();
            localTracks.audioEffectTrack.startProcessAudioBuffer({
                cycle
            });
        }
        async function join() {
            // add event listener to play remote tracks when remote user publishs.
            client.on("user-published", handleUserPublished);
            client.on("user-unpublished", handleUserUnpublished);

            // join a channel and create local tracks, we can use Promise.all to run them concurrently
            [options.uid, localTracks.audioTrack, localTracks.videoTrack] = await Promise.all([
                // join the channel
                client.join(options.appid, options.channel, options.token || null, options.uid || null),
                // create local tracks, using microphone and camera
                AgoraRTC.createMicrophoneAudioTrack({
                    encoderConfig: "music_standard"
                }), AgoraRTC.createCameraVideoTrack()
            ]);
            // play local video track
            localTracks.videoTrack.play("local-player");
            $("#local-player-name").text(`localVideo(${options.uid})`);

            // publish local tracks to channel
            await client.publish(Object.values(localTracks).filter(track => track !== null));
            console.log("publish success");
        }
        async function leave() {
            stopAudioMixing();
            for (trackName in localTracks) {
                var track = localTracks[trackName];
                if (track) {
                    track.stop();
                    track.close();
                    localTracks[trackName] = null;
                }
            }
            // remove remote users and player views
            remoteUsers = {};
            $("#remote-playerlist").html("");

            // leave the channel
            await client.leave();
            $("#local-player-name").text("");
            $("#join").attr("disabled", false);
            $("#leave").attr("disabled", true);
            $("#local-audio-mixing").attr("disabled", true);
            console.log("client leaves channel success");
        }
        async function subscribe(user, mediaType) {
            const uid = user.uid;
            // subscribe to a remote user
            await client.subscribe(user, mediaType);
            console.log("subscribe success");
            if (mediaType === 'video') {
                const player = $(`
      <div id="player-wrapper-${uid}">
        <p class="player-name">remoteUser(${uid})</p>
        <div id="player-${uid}" class="player"></div>
      </div>
    `);
                $("#remote-playerlist").append(player);
                user.videoTrack.play(`player-${uid}`);
            }
            if (mediaType === 'audio') {
                user.audioTrack.play();
            }
        }

        function handleUserPublished(user, mediaType) {
            const id = user.uid;
            remoteUsers[id] = user;
            subscribe(user, mediaType);
        }

        function handleUserUnpublished(user, mediaType) {
            if (mediaType === 'video') {
                const id = user.uid;
                delete remoteUsers[id];
                $(`#player-wrapper-${id}`).remove();
            }
        }

        // calculate the MM:SS format from millisecond
        function toMMSS(second) {
            // const second = millisecond / 1000;
            let MM = parseInt(second / 60);
            let SS = parseInt(second % 60);
            MM = MM < 10 ? "0" + MM : MM;
            SS = SS < 10 ? "0" + SS : SS;
            return `${MM}:${SS}`;
        }
    </script>
@endsection
