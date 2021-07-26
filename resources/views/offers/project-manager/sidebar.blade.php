<div class="sidebar-container">
    <!-- Location -->
    <div class="sidebar-widget d-none">
        <h3>Location</h3>
        <div class="input-with-icon">
            <div id="autocomplete-container">
                <input id="autocomplete-input" type="text" placeholder="Location">
            </div>
            <i class="icon-material-outline-location-on"></i>
        </div>
    </div>

    <!-- Keywords -->
    <div class="sidebar-widget">
        <h3>Keywords</h3>
        <div class="keywords-container">
            <div class="keyword-input-container">
                <input type="text" class="keyword-input" placeholder="e.g. job title" />
                <button class="keyword-input-button ripple-effect"><i class="icon-material-outline-add"></i></button>
            </div>
            <div class="keywords-list" id="contest-keywords-list">
                @foreach ($filter_keywords as $keyword)
                    @if (trim($keyword) != '')
                        <span class="keyword">
                            <span class="keyword-remove"></span>
                            <span class="keyword-text">{{ $keyword }}</span>
                        </span>
                    @endif
                @endforeach
            </div>
            <div class="clearfix"></div>
        </div>
    </div>

    <!-- Category -->
    {{-- <div class="sidebar-widget d-none">
        <h3>Category</h3>
        <select class="selectpicker contests-filter" data-filter="category" multiple data-selected-text-format="count"
            data-size="7" title="All Categories">
            @foreach ($categories as $category)
                <option value="{{ $category->id }}"
                    {{ in_array($category->id, $filter_categories) ? 'selected' : '' }}>{{ $category->title }}
                </option>
            @endforeach
        </select>
    </div> --}}

    <!-- Category -->
    <div class="sidebar-widget">
        <h3>Freelancer Level</h3>
        <select class="contests-filters" name="freelancer_level">
            <option value="0">Anyone can apply</option>
            <option value="3">Minimum of 3 stars</option>
            <option value="5">Only 5 stars</option>
        </select>
    </div>

    <!-- Job Types -->
    <div class="sidebar-widget d-none">
        <h3>
            Freelancer Level
        </h3>

        <div class="switches-list">
            <div class="switch-container">
                <label class="switch"><input type="checkbox"><span class="switch-button"></span>
                    Freelance</label>
            </div>

            <div class="switch-container">
                <label class="switch"><input type="checkbox"><span class="switch-button"></span>
                    Full Time</label>
            </div>

            <div class="switch-container">
                <label class="switch"><input type="checkbox"><span class="switch-button"></span>
                    Part Time</label>
            </div>

            <div class="switch-container">
                <label class="switch"><input type="checkbox"><span class="switch-button"></span>
                    Internship</label>
            </div>
            <div class="switch-container">
                <label class="switch"><input type="checkbox"><span class="switch-button"></span>
                    Temporary</label>
            </div>
        </div>

    </div>

    <!-- Salary -->
    <div class="sidebar-widget d-none">
        <h3>Salary</h3>
        <div class="margin-top-55"></div>

        <!-- Range Slider -->
        <input class="range-slider" type="text" value="" data-slider-currency="$" data-slider-min="1500"
            data-slider-max="15000" data-slider-step="100" data-slider-value="[1500,15000]" />
    </div>

    <!-- Tags -->
    <div class="sidebar-widget">
        <h3>Tags</h3>

        <div class="tags-container">
            <div class="tag">
                <input type="checkbox" id="tag1" />
                <label for="tag1">front-end dev</label>
            </div>
            <div class="tag">
                <input type="checkbox" id="tag2" />
                <label for="tag2">angular</label>
            </div>
            <div class="tag">
                <input type="checkbox" id="tag3" />
                <label for="tag3">react</label>
            </div>
            <div class="tag">
                <input type="checkbox" id="tag4" />
                <label for="tag4">vue js</label>
            </div>
            <div class="tag">
                <input type="checkbox" id="tag5" />
                <label for="tag5">web apps</label>
            </div>
            <div class="tag">
                <input type="checkbox" id="tag6" />
                <label for="tag6">design</label>
            </div>
            <div class="tag">
                <input type="checkbox" id="tag7" />
                <label for="tag7">wordpress</label>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>

</div>
