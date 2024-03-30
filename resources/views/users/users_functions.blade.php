<script>
    checkOptions();

    function checkOptions() {
        var options = document.getElementById('kt_select2_1').selectedOptions;
        var script = document.createElement('script');
        script.src = '{{ asset("admin/assets/js/select2.js") }}';
        document.body.appendChild(script);

        checkAndAppend('Author', '#kt_select2_3', `
            <label>Select Author</label>
            <select required name="author_id" id="kt_select2_3" class="form-control">
                <option value="">Select Status</option>
                @foreach ($authors as $author )
                    <option value="{{ $author->id }}" {{ $author->id == $user_author_id ? "selected" : "" }}>{{ $author->name }}</option>
                @endforeach
            </select>
        `, '.author_selector');

        checkAndAppend('Playlist', '#kt_select2_4', `
            <label>Select Playlist</label>
            <select required name="playlists[]" id="kt_select2_4" class="form-control" multiple>
                <option value="">Select Status</option>
                @foreach ($playlists as $playlist )
                    <option value="{{ $playlist->id }}" {{ is_array($user_playlists) && in_array($playlist->id, $user_playlists) ? 'selected' : '' }}>{{ $playlist->title }}</option>
                @endforeach
            </select>
        `, '.playlist_selector');

        checkAndAppend('Channel', '#kt_select2_5', `
            <label>Select Channel</label>
            <select required name="channel_id" id="kt_select2_5" class="form-control">
                <option value="">Select Channel</option>
                @foreach ($channels as $channel )
                    <option value="{{ $channel->id }}">{{ $channel->name }}</option>
                @endforeach
            </select>
        `, '.channel_selector');
    }

    function checkAndAppend(optionText, selectorId, html, className) {
        var options = document.getElementById('kt_select2_1').selectedOptions;
        var elementExists = document.querySelector(selectorId);
        var texts = Array.from(options).map(option => option.innerText);

        newElement = document.createElement('div');
        newElement.classList.add('col-lg-4', 'col-md-9', 'col-sm-12', className.substr(1));
        newElement.innerHTML = html;

        if (texts.includes(optionText) && elementExists == null) {
            document.querySelector('#author_selector').appendChild(newElement);
        } else {
            if (!texts.includes(optionText) && elementExists) {
                document.querySelector(className).remove();
            }
        }
    }
</script>
