# Album

    - HasAlbum :Trait
        - album Morph :Album
        - createAlbum :Album
        
    - Album 
        - addImage :void
        - removeImage :bool
        - setImageAsCover :void
        - images :relation hasMany
        - image :cover image
        
        
     - Image
        - store :Image|null
        - delete_file :void
        - makeDirectory ($path, $mode, $recursive, $force) :void
        - delete_all_size :bool
        - create_image ($width, $size_type, $folder) :Image
        - xs hasOne :Image
        - lg hasOne :Image
        - md hasOne :Image
        - sm hasOne :Image
        - xl hasOne :Image
     