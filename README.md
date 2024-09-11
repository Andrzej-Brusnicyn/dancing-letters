# Dancing Letters

### A PHP program that takes a word (string) and creates a long GIF animation using dancing letter images that correspond to the characters of the input word.

------------

#### Example of Class Usage

```php
    require_once 'GenGif.php';
    
    $genGif = new GenGif('Hello');
    $genGif->createGIF();
```

This will create a GIF animation of dancing letters for the word "Hello".

#### How It Works
<details>
<summary>In Imagick, a GIF animation is represented as a collection of individual frames that can be iterated over in cycles.</summary>

1. **Initialization of Constants:** The *GenGif* class contains two constants:
	- *GenGif::SPACE* — sets the width of the empty space for a blank character.
	- *GenGif::FRAMELIMIT* — sets the number of frames in the final animation.

2. **Class Initialization:** The object is initialized with the given word.

3. **Generating Paths to GIF Files:** The *genGifPaths()* method creates paths to the GIF files for each letter of the word, for example, h.gif for the letter "h".

4. **Loading GIF Files:** The *loadGifImages()* method:
	- Loads GIF files from the previously generated paths and creates *Imagick* objects from them.
	- Handles spaces by creating empty images for blank characters and adding them to the array.

5. **Calculating the Size of the Final Animation:** The calculateSize() method calculates the total width and maximum height of all loaded GIF files, which is necessary for combining them into a single frame.

6. **Merging Images:** The *mergeImages()* method:
	- Creates a new Imagick object for the final animation.
	- The outer loop creates each frame of the new animation.
	- The inner loop composites each GIF image from the array onto the current frame with an offset to the right along the X-axis, creating sequential frames of the final animation.
	
7. **Outputting the Result:** The *outputResult()* method outputs the final GIF animation as a BLOB, which can be displayed in the browser.
</details>

#### Settings
1. **Spaces:** *GenGif::SPACE* — sets the width of the empty space for blank characters between letters.
2. **Number of Frames:** *GenGif::FRAMELIMIT* — sets the number of frames in the final animation.
3. **Paths to GIF Files:** The path to the files is set by the *$gifPathPrefix* property, defaulting to *./assets/gif/.* For the class to work correctly, the *./assets/gif/* folder must contain GIF files of dancing letters, for example:
	- a.gif
	- b.gif
	- ...
	- z.gif

#### Dependencies
1. **PHP:** Version 7.4 or higher.
2. **Imagick:** The Imagick extension for PHP, which is required for working with images.
