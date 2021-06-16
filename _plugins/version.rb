module Jekyll
    module VersionFilter
        def version_number(input, index)
            if !input.nil?
                numbers = input.split('.')
                if numbers.length == 3
                    return numbers[index].to_i
                end
            end
            input
        end
    end
    module MajorVersionFilter
        include VersionFilter
        def major(input)
            version_number(input, 0)
        end
    end
    module MinorVersionFilter
        include VersionFilter
        def minor(input)
            version_number(input, 1)
        end
    end
    module PatchVersionFilter
        include VersionFilter
        def patch(input)
            version_number(input, 2)
        end
    end
end
Liquid::Template.register_filter(Jekyll::MajorVersionFilter)
Liquid::Template.register_filter(Jekyll::MinorVersionFilter)
Liquid::Template.register_filter(Jekyll::PatchVersionFilter)